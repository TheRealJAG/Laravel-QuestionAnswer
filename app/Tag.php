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
     * Returns an object off all the tags being used by questions.
     * @return object
     */
    public static function get_tags() {
        return Tag::distinct()->orderBy('name', 'asc')->get();
    }

}
