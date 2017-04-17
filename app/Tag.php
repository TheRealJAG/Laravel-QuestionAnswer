<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tag extends Model
{

    private static $pagination_count = 10;

    // Bind the questions
    // use count() to get number of questions per tag.
    public function questions() {
        return $this->belongsToMany('App\Question', 'tags_questions', 'tag_id','question_id');
    }

    /**
     * Returns questions sorted by most answers according to the tag object
     * @param $tags - Tags object returned from get_tags()
     * @return mixed
     */
    public static function most_answered($tags) {
        $tag_array = array();
        foreach($tags as $object)
            $tag_array[] = $object->name;

        $questions = Question::join('answers', 'questions.id', '=', 'answers.question_id')
            ->join('tags_questions', 'tags_questions.question_id', '=', 'questions.id')
            ->join('tags', 'tags.id', '=', 'tags_questions.tag_id')
            ->select('questions.*', DB::raw('count(answers.id) as answers_ttl'))
            ->whereIn('tags.name', $tag_array)
            ->groupBy('questions.id')
            ->orderBy('answers_ttl', 'desc')
            ->orderBy('questions.created_at', 'desc')
            ->paginate(self::$pagination_count);
        return $questions;
    }

    /**
     * Returns un questions sorted by most answers according to the tag object
     * @param $tags - Tags object returned from get_tags()
     * @return mixed
     */
    public static function unanswered($tags) {
        $tag_array = array();
        foreach($tags as $object)
            $tag_array[] = $object->name;

        $questions = Question::leftJoin('answers', 'questions.id', '=', 'answers.question_id')
            ->join('votes', 'questions.id', '=', 'votes.question_id')
            ->join('tags_questions', 'tags_questions.question_id', '=', 'questions.id')
            ->join('tags', 'tags.id', '=', 'tags_questions.tag_id')
            ->select('questions.*', DB::raw('sum(votes.vote) as vote_ttl'))
            ->whereIn('tags.name', $tag_array)
            ->whereNull('answers.id')
            ->groupBy('questions.id')
            ->orderBy('vote_ttl', 'desc')
            ->orderBy('questions.created_at', 'desc')
            ->paginate(self::$pagination_count);
        return $questions;
    }
}
