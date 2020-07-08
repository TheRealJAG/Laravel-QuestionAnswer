<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Question extends Model
{
    // Pagination Counts
    private static $pagination_count = 10;
    private static $pagination_count_min = 5;

    // Create the relationship to users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Create the relationship to answers
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    // Create the relationship to votes
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // Using a relationship table or a 'pivot' table.
    // Use ->count() to get total
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'question_tag', 'question_id', 'tag_id');
    }

    /**
     * Returns pagination count based on if int is > 0.
     * @param int $int
     * @return int
     */
    private static function get_pagination($int)
    {
        if ($int > 0) {
            return self::$pagination_count_min;
        } else {
            return self::$pagination_count;
        }
    }

    /**
     * Returns questions sorted by most answers according to the tag object.
     * @param $tags - Tags object returned from get_tags()
     * @return mixed
     */
    public static function most_answered($tags)
    {
        return self::join('answers', 'questions.id', '=', 'answers.question_id')
            ->join('question_tag', 'question_tag.question_id', '=', 'questions.id')
            ->join('tags', 'tags.id', '=', 'question_tag.tag_id')
            ->select('questions.*', DB::raw('count(answers.id) as answers_ttl'))
            ->whereIn('tags.name', $tags)
            ->groupBy('questions.id')
            ->orderBy('answers_ttl', 'desc')
            ->orderBy('questions.created_at', 'desc')
            ->paginate(self::$pagination_count);
    }

    /**
     * Returns un questions sorted by most answers according to the tag object.
     * @param $tags - Tags object returned from get_tags()
     * @return mixed
     */
    public static function unanswered($tags)
    {
        return self::leftJoin('answers', 'questions.id', '=', 'answers.question_id')
            ->join('votes', 'questions.id', '=', 'votes.question_id')
            ->join('question_tag', 'question_tag.question_id', '=', 'questions.id')
            ->join('tags', 'tags.id', '=', 'question_tag.tag_id')
            ->select('questions.*', DB::raw('sum(votes.vote) as vote_ttl'))
            ->whereIn('tags.name', $tags)
            ->whereNull('answers.id')
            ->groupBy('questions.id')
            ->orderBy('vote_ttl', 'desc')
            ->orderBy('questions.created_at', 'desc')
            ->paginate(self::$pagination_count);
    }

    /**
     * Get the number of answers for a question.
     * @return mixed
     */
    public function answer_count()
    {
        return $this->answers()
            ->selectRaw('count(*) as total, question_id')
            ->groupBy('question_id');
    }

    /**
     * Get relevant questions except for $question_id.
     * @param $tags
     * @param int $question_id
     * @return mixed
     */
    public static function recent_relevant($tags, $question_id = 0)
    {
        return self::join('question_tag', 'question_tag.question_id', '=', 'questions.id')
            ->join('tags', 'tags.id', '=', 'question_tag.tag_id')
            ->select('questions.*')
            ->where('questions.id', '!=', $question_id)
            ->whereIn('tags.name', $tags)
            ->orderBy('questions.id', 'desc')
            ->paginate(self::get_pagination($question_id));
    }

    /**
     * Returns relevant questions sorted by vote according to the tag object.
     * @param $tags - Tags array returned from get_tags()
     * @param int $question_id
     * @return mixed
     */
    public static function top_relevant($tags, $question_id = 0)
    {
        return self::join('votes', 'questions.id', '=', 'votes.question_id')
            ->join('question_tag', 'question_tag.question_id', '=', 'questions.id')
            ->join('tags', 'tags.id', '=', 'question_tag.tag_id')
            ->select('questions.*', DB::raw('sum(votes.vote) as vote_ttl'))
            ->whereIn('tags.name', $tags)
            ->where('questions.id', '!=', $question_id)
            ->groupBy('questions.id')
            ->orderBy('vote_ttl', 'desc')
            ->orderBy('questions.created_at', 'desc')
            ->paginate(self::get_pagination($question_id));
    }

    /**
     * Returns relevant questions sorted by vote count.
     * @return mixed
     */
    public static function top()
    {
        return self::join('votes', 'questions.id', '=', 'votes.question_id')
            ->select('questions.*', DB::raw('sum(votes.vote) as vote_ttl'))
            ->groupBy('questions.id')
            ->orderBy('vote_ttl', 'desc')
            ->orderBy('questions.created_at', 'desc')
            ->paginate(self::$pagination_count);
    }

    /**
     * Returns relevant questions sorted by vote count.
     * @param int $limit - Number of questions to return
     * @return mixed
     */
    public static function top_limited($limit)
    {
        return self::join('votes', 'questions.id', '=', 'votes.question_id')
            ->select('questions.*', DB::raw('sum(votes.vote) as vote_ttl'))
            ->groupBy('questions.id')
            ->where('questions.created_at', '>=', '2013-04-29 02:10:22')
            ->orderBy('vote_ttl', 'desc')
            ->orderBy('questions.created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Returns tags for the question.
     * @param $id
     * @return mixed
     */
    public static function get_tags($id)
    {
        return self::join('question_tag', 'question_tag.question_id', '=', 'questions.id')
            ->join('tags', 'tags.id', '=', 'question_tag.tag_id')
            ->where('question_tag.question_id', '=', $id)
            ->select('tags.name')
            ->get();
    }

    /**
     * Insert the question to the table.
     * @param $user_id
     * @param $tags
     * @param $question_text
     * @return object
     */
    public static function insert($user_id, $tags, $question_text)
    {
        $question = new self;
        $question->question = $question_text;
        $question->user_id = $user_id;
        $question->save();

        if (! empty($tags)) {
            $tags = array_unique(explode(',', $tags));
            if (is_array($tags)) {
                foreach ($tags as $tag) {
                    DB::table('question_tag')->insert(
                        ['tag_id' => $tag, 'question_id' => $question->id]
                    );
                }
            }
        }

        // Give a vote to the new question by author
        Vote::vote($user_id, $question->id, 1, 'question_id');

        return $question;
    }

    /**
     * Search.
     * @param string $query
     * @return object
     */
    public static function search($query)
    {
        return self::join('answers', 'questions.id', '=', 'answers.question_id')
            ->join('votes', 'questions.id', '=', 'votes.question_id')
            ->join('question_tag', 'question_tag.question_id', '=', 'questions.id')
            ->join('tags', 'tags.id', '=', 'question_tag.tag_id')
            ->select('questions.*', DB::raw('sum(votes.vote) as vote_ttl'))
            ->where('questions.question', 'LIKE', '%'.$query.'%')
            ->orWhere('answers.answer', 'LIKE', '%'.$query.'%')
            ->orWhere('tags.name', 'LIKE', '%'.$query.'%')
            ->groupBy('questions.id')
            ->orderBy('vote_ttl', 'desc')
            ->orderBy('questions.created_at', 'desc')
            ->paginate(self::$pagination_count);
    }
}
