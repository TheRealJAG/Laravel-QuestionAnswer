<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    // Bind the questions
    // use count() to get number of questions per tag.
    public function questions() {
        return $this->belongsToMany('App\Question', 'tags_questions', 'tag_id','question_id');
    }
}
