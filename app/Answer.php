<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Answer extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function question() {
        return $this->belongsTo('App\Question');
    }
    public function votes() {
        return $this->hasMany('App\Vote');
    }

    /**
     * Insert an answer
     */
    public static function insert() {
        $answer = new Answer;
        $answer->answer = Request::get('answer');
        $answer->user_id = Auth::user()->id;
        $answer->question_id = Request::get('question_id');
        $answer->save();
        return $answer;
    }

    /**
     * Update an answer
     */
    public static function update_answer() {
        $answer_id = Request::get('pk');
        $answer = Request::get('value');
        $answer_data = Answer::whereId($answer_id)->first();
        $answer_data->answer = $answer;
        if($answer_data->save())
            return true;
        else
            return false;
    }

    /**
     * Get answers and sort by vote sum()
     * @param $question_id
     * @return mixed
     */
    public static function get_sorted($question_id) {
        $answer = Answer::where('question_id', '=', $question_id)->get();
        $answer = $answer->sortByDesc(function ($answer) {
            return $answer->votes->sum('vote');
        });
        return $answer;
    }

    /**
     * Get answers and sort by vote sum()
     * @param $question_id
     * @return mixed
     */
    public static function get_answer_ids($question_id) {
        $answer_ids = Answer::select('user_id')->distinct()->where('question_id', $question_id)->get()->toArray();

        // todo move this
        $answer_array = array();
        foreach($answer_ids as $var)
            $answer_array[] = $var['user_id'];

        return $answer_array;
    }

}
