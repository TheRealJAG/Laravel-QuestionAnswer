<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
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
}

