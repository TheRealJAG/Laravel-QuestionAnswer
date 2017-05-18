<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Events\VoteEvent;

class Vote extends Model
{
    protected $events = [
        'created' => VoteEvent::class,
        'updated' => VoteEvent::class
    ];

    protected $fillable = [
        'user_id',
        'answer_id',
        'question_id',
        'vote'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function answer() {
        return $this->belongsTo('App\Answer');
    }

    // Is the current and past vote the same? The user deselected the upvote/downvote...
    // If so, remove all votes relating to question.
    // todo same goes for answer
    public static function vote_question($user_id, $question_id, $vote) {
        $voted = Vote::where('user_id', $user_id)->where('question_id',$question_id)->first();

        if (isset($voted->id)) {
            Vote::destroy($voted->id);
            $ajax_response = array(
                'status' => 'success',
                'msg' => 'vote nullified on question id ' .$question_id,
            );
        } else {
            Vote::updateOrCreate(
                ['question_id' => $question_id,'user_id' => $user_id],
                ['vote' => $vote]
            );
            $ajax_response = array(
                'status' => 'success',
                'msg' => 'vote casted on question id ' . $question_id,
            );
        }
        return $ajax_response;
    }


    public static function vote_answer($user_id,$answer_id,$vote) {
        $voted = Vote::where('user_id', $user_id)
            ->where('answer_id',$answer_id)
            ->first();

        if (isset($voted->id)) {
            Vote::destroy($voted->id);
            $ajax_response = array(
                'status' => 'success',
                'msg' => 'vote nullified',
            );
        } else {
            Vote::updateOrCreate(
                ['answer_id' => $answer_id,'user_id' => Auth::user()->id],
                ['vote' => $vote]
            );

            $ajax_response = array(
                'status' => 'success',
                'msg' => 'vote casted...',
            );
        }
        return $ajax_response;
    }
}