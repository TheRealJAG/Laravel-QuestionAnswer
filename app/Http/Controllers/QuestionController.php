<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
    public function show($id)
    {
        $question = Question::find($id);

        if (!$question)
            abort(404, "Page Not Found");

        return view('question', ['answer_ids' => Answer::get_answer_ids($id), 'recent_questions' => Question::top_relevant(Question::get_tags($id)->toArray(),$id), 'answers' => Answer::get_sorted($id), 'question' => $question, 'page_title' => $question->question, 'is_question' => true]);
    }

    /**
     * Get the top questions according to votes
     * GET /questions/top
     * @return Redirect
     */
    public function top()
    {
        return view('questions.top', ['questions' => Question::top(), 'page_title' => 'Top Questions', 'sort' =>'top']);
    }

    /**
     * Get the newest questions
     * GET /questions/new
     * @return Redirect
     */
    public function newest()
    {
        return view('questions.new', ['questions' => Question::orderBy('created_at', 'desc')->paginate(10), 'page_title' => 'New Questions', 'sort' =>'new']);
    }

    /**
     * Insert question in DB
     * POST /questions
     * @return Redirect
     */
    public function insert()
    {
        $question = Question::insert(Auth::user()->id, Request::get('tags'), Request::get('question'), Request::get('level'));
        return Redirect::to('question/'.$question->id.'/'.\App\Classes\URL::get_slug($question->question));
    }

    /**
     * Get the newest questions
     * GET /questions/new
     * @return Redirect
     */
    public function edit($id)
    {
        return view('questions.edit', ['question' => Question::find($id), 'page_title' => 'Edit Questions']);
    }
    /**
     * Get the newest questions
     * GET /questions/new
     * @return Redirect
     */
    public function edit_save()
    {
        $id =  Request::get('id');
        $question = Request::get('question');

        $q = Question::find($id);
        $q->question = $question;
        $q->save();
        return Redirect::to('question/'.$id.'/'.\App\Classes\URL::get_slug($question));
    }
}