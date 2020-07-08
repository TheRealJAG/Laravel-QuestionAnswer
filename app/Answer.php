<?php

namespace App;

use App\Events\AnswerEvent;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $events = [
        'created' => AnswerEvent::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Insert an answer.
     * @param $answer_text
     * @param $question_id
     * @param $user_id
     * @return Answer
     */
    public static function insert($answer_text, $question_id, $user_id)
    {
        $answer = new self;
        $answer->answer = $answer_text;
        $answer->user_id = $user_id;
        $answer->question_id = $question_id;
        $answer->save();

        return $answer;
    }

    /**
     * Update an answer.
     * @param $answer_id
     * @param $answer
     * @return bool
     */
    public static function update_answer($answer_id, $answer)
    {
        $answer_data = self::whereId($answer_id)->first();
        $answer_data->answer = $answer;
        if ($answer_data->save()) {
            return true;
        }
    }

    /**
     * Get answers and sort by vote sum().
     * @param $question_id
     * @return mixed
     */
    public static function get_sorted($question_id)
    {
        $answer = self::where('question_id', '=', $question_id)->get();

        return $answer->sortByDesc(function ($answer) {
            return $answer->votes->sum('vote');
        });
    }

    /**
     * Get answers and sort by vote sum().
     * @param $question_id
     * @return mixed
     */
    public static function get_answer_ids($question_id)
    {
        $answer_ids = self::select('user_id')->distinct()->where('question_id', $question_id)->get()->toArray();

        $answer_array = [];
        foreach ($answer_ids as $var) {
            $answer_array[] = $var['user_id'];
        }

        return $answer_array;
    }
}
