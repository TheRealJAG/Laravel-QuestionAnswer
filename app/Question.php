<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class Question extends Model {

    // Create the relationship to users
    public function user() {
        return $this->belongsTo('App\User');
    }

    // Create the relationship to answers
    public function answers() {
        return $this->hasMany('App\Answer');
    }

    // Create the relationship to votes
    public function votes() {
        return $this->hasMany('App\Vote');
    }

    // Using a relationship table or a 'pivot' table.
    // Use ->count() to get total
    public function tags() {
        return $this->belongsToMany('App\Tag', 'tags_questions', 'question_id','tag_id');
    }

    /**
     * Get the number of answers for a question
     * @return mixed
     */
    public function answer_count() {
        return $this->answers()
            ->selectRaw('count(*) as total, question_id')
            ->groupBy('question_id');
    }
    /**
     * Returns relevant questions according to the tag object
     * @param $tags - Tags object returned from get_tags()
     * @return mixed
     */
    public static function recent_relevant($tags,$question_id=0) {

        // Convert $tags object to array for whereIn()
        $tag_array = array();
        foreach($tags as $object)
            $tag_array[] = $object->name;

        if ($question_id > 0) $num = 5;
            else $num = 10;

        // Get relevant questions except for $question_id
        // Attach AnswersCount - # answers per question
        $questions = Question::join('tags_questions', 'tags_questions.question_id', '=', 'questions.id')
            ->join('tags', 'tags.id', '=', 'tags_questions.tag_id')
            ->select('questions.*')
            ->where('questions.id', '!=' , $question_id)
            ->whereIn('tags.name', $tag_array)
            ->orderBy('questions.id', 'desc')
            ->paginate($num);

        return $questions;
    }


    /**
     * Returns relevant questions sorted by vote according to the tag object
     * @param $tags - Tags object returned from get_tags()
     * @return mixed
     */
    public static function top_relevant($tags,$question_id=0) {

        if ($question_id > 0) $num = 5;
        else $num = 10;

        // Convert $tags object to array for whereIn()
        $tag_array = array();
        foreach($tags as $object)
            $tag_array[] = $object->name;

        $questions = Question::join('votes', 'questions.id', '=', 'votes.question_id')
            ->join('tags_questions', 'tags_questions.question_id', '=', 'questions.id')
            ->join('tags', 'tags.id', '=', 'tags_questions.tag_id')
            ->select('questions.*', DB::raw('sum(votes.vote) as vote_ttl'))
            ->whereIn('tags.name', $tag_array)
            ->groupBy('questions.id')
            ->orderBy('vote_ttl', 'desc')
            ->orderBy('questions.created_at', 'desc')
            ->paginate($num);

        return $questions;
    }

    /**
     * Returns relevant questions sorted by vote according to the tag object
     * @param $tags - Tags object returned from get_tags()
     * @return mixed
     */
    public static function top() {
        $questions = Question::join('votes', 'questions.id', '=', 'votes.question_id')
            ->select('questions.*', DB::raw('sum(votes.vote) as vote_ttl'))
            ->groupBy('questions.id')
            ->orderBy('vote_ttl', 'desc')
            ->orderBy('questions.created_at', 'desc')
            ->paginate(10);
        return $questions;
    }

    /**
     * Returns tags for the question
     * @param $id
     * @return mixed
     */
    public static function get_tags($id) {
        $tags = Question::join('tags_questions', 'tags_questions.question_id', '=', 'questions.id')
            ->join('tags', 'tags.id', '=', 'tags_questions.tag_id')
            ->where('tags_questions.question_id', '=', $id)
            ->select('tags.*')
            ->get();

        return $tags;
    }

    /**
     * Takes the question and makes a url string, SEO related.
     * @param $question - Question string like a title.
     * @return string
     */
    public static function get_url($question) {

        $question = strtolower(strip_tags($question));
        // Preserve escaped octets.
        $question = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $question);
        // Remove percent signs that are not part of an octet.
        $question = str_replace('%', '', $question);
        // Restore octets.
        $question = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $question);
        $question = preg_replace('/&.+?;/', '', $question); // kill entities
        $question = str_replace('.', '-', $question);
        $question = preg_replace('/[^%a-z0-9 _-]/', '', $question);
        $question = preg_replace('/\s+/', '-', $question);
        $question = preg_replace('|-+|', '-', $question);
        $question = trim($question, '-');

        // If we want to add stop words in the future, this is where we do it.
        $stopwords = explode( ',',"a,an,and,are,is,the,of,for,in,what,whats,or,to,how,do,you,they,its,if,can,test,does,on,that,was");

        $new_slug_parts = array_diff( explode( '-', $question ), $stopwords );

        // Don't change the slug if there are less than 3 words left after removing stop words
        if ( count( $new_slug_parts ) < 3 ) {
            return $question;
        }

        // Turn the sanitized array into a string.
        // Results in formatted SEO friendly string
        $question = join( '-', $new_slug_parts );
        return $question;
    }

    /**
     * Insert the question to the table.
     * @return object
     */
    public static function insert() {
        $tags = Request::get('tags');
        $question = new Question;
        $question->question = Request::get('question');
        $question->level = Request::get('level');
        $question->user_id = Auth::user()->id;
        $question->save();

        // todo There might be a better way to handle this in Laravel
        $tags = array_unique(explode(',',$tags));

        // Don't have a model for tags_questions
        foreach ($tags as $tag) {
            DB::table('tags_questions')->insert(
                ['tag_id' => $tag, 'question_id' => $question->id]
            );
        }
        return $question;
    }
}

