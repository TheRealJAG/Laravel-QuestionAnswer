<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\DB;

use App\Question;

class User extends Authenticatable
{
    //use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function votes() {
        return $this->hasMany('App\Vote');
    }

    public static function get_participation($user_id) {

        $questions = Question::join('answers', 'questions.user_id', '=', 'answers.user_id')
            ->select(['questions.*'])
            ->distinct()
            ->with('answer_count')
            ->where([
                ['questions.user_id', '=', $user_id],
                ['answers.user_id', '=', $user_id],
            ])
            ->paginate(10, ['questions.*']);

        return $questions;
    }


}
