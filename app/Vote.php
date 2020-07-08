<?php

namespace App;

use App\Events\VoteEvent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vote.
 */
class Vote extends Model
{
    protected $events = [
        'created' => VoteEvent::class,
        'updated' => VoteEvent::class,
    ];

    protected $fillable = [
        'user_id',
        'answer_id',
        'question_id',
        'vote',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Insert/Update & Delete from votes table
     * If identical previous/new vote destroy otherwise insert/update.
     * @param $user_id
     * @param $id - ID question/answer
     * @param $vote - Integer of vote value
     * @param $column - the vote table uses question_id or answer_id
     * @return array
     */
    public static function vote($user_id, $id, $vote, $column)
    {
        $voted = self::where('user_id', $user_id)->where($column, $id)->first();
        if (isset($voted->vote) && $voted->vote == $vote) {
            self::destroy($voted->id);
            $ajax_response = ['status' => 'success', 'msg' => "Vote nullified on $column $id"];
        } else {
            self::updateOrCreate([$column => $id, 'user_id' => $user_id], ['vote' => $vote]);
            $ajax_response = ['status' => 'success', 'msg' => "Vote cast on $column $id"];
        }

        return $ajax_response;
    }
}
