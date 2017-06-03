<?php
namespace App\Classes;

use App\Question;

/**
 * Class QuestionValidation
 * Business logic for questions
 * @package App\Classes
 */
class QuestionValidation
{

    // Check for duplicate question(s)
    // If found will return first record.
    public static function CheckDuplicateStrict($question, $tag) {
        $tags = explode(",", $tag);
        $does_exist = Question::join('tags_questions', 'tags_questions.question_id', '=', 'questions.id')
            ->join('tags', 'tags.id', '=', 'tags_questions.tag_id')
            ->select('questions.*')
            ->where('question', '=', $question);
        foreach ($tags as $tag_id) {
            $rec = $does_exist->whereHas('tags', function ($q) use ($tag_id) {
                $q->where('tags_questions.tag_id', $tag_id);
            });
        }
        $questions = $rec->get();

        if (isset($questions[0])) {
            return $questions[0];
        }  else {
            return false;
        }
    }

    public static function CheckDuplicateLoose($question, $tag) {
        $tags = explode(",", $tag);

        $does_exist = Question::join('tags_questions', 'tags_questions.question_id', '=', 'questions.id')
            ->join('tags', 'tags.id', '=', 'tags_questions.tag_id')
            ->select('questions.*')
            ->where('question', '=', $question)
            ->whereIn('id', $tags)
            ->get();

        if (isset($does_exist[0])) {
            return $does_exist[0];
        }  else {
            return false;
        }
    }

}