<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

use App\Answer;
use App\Question;
use App\Tag;

class QuestionController extends Controller
{
    /**
     * Display the question
     * @param  int  $question_id
     * @return Response
     */
    public function show($question_id)
    {
        $question = Question::find($question_id);
        $question_tags = Question::get_tags($question_id);
        $recent_questions = Question::top_relevant($question_tags,$question_id);
        $answers = Answer::get_sorted($question_id);
        $answer_ids = Answer::get_answer_ids($question_id);
        $tags = Tag::distinct()->orderBy('name', 'asc')->get();
        return view('question')
            ->with('answer_ids',$answer_ids)
            ->with('recent_questions',$recent_questions)
            ->with('answers',$answers)
            ->with('question',$question)
            ->with('page_title',$question->question)
            ->with('tags', $tags);
    }

    /**
     * Insert question in DB
     * POST /questions
     * @return Redirect
     */
    public function insert()
    {
        $question = Question::insert();
        return Redirect::to('question/'.$question->id.'/'.\App\Question::get_url($question->question));
    }

    /**
     * Get the top questions according to votes
     * GET /questions/top
     * @return Redirect
     */
    public function top()
    {
        $questions = Question::top();
        $tags = Tag::distinct()->orderBy('name', 'asc')->get();
        return view('questions.top')
            ->with('questions',$questions)
            ->with('page_title','Top Questions')
            ->with('sort','top')->with('tags',$tags);
    }

    /**
     * Get the newest questions
     * GET /questions/new
     * @return Redirect
     */
    public function newest()
    {
        $questions = Question::orderBy('created_at', 'desc')->paginate(10);
        $tags = Tag::distinct()->orderBy('name', 'asc')->get();
        return view('questions.new')
            ->with('questions',$questions)
            ->with('page_title','Top Questions')
            ->with('sort','new')
            ->with('tags',$tags);
    }
}
