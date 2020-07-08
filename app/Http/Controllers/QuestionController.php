<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Classes\QuestionValidation;
use App\Classes\Url;
use App\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class QuestionController extends Controller
{
    /**
     * Display the question.
     * @param Question $question
     * @return Response
     */
    public function show(Question $question)
    {
        return view(
            'question',
            [
                'answer_ids' => Answer::get_answer_ids($question),
                'recent_questions' => Question::top_relevant(
                    Question::get_tags($question->id)->toArray(),
                    $question->id
                ),
                'answers' => Answer::get_sorted($question),
                'question' => $question,
                'page_title' => $question->question,
                'is_question' => true
            ]
        );
    }

    /**
     * Get the top questions according to votes
     * GET /questions/top.
     * @return Redirect
     */
    public function top()
    {
        return view('questions.top', ['questions' => Question::top(), 'page_title' => 'Top Questions', 'sort' =>'top']);
    }

    /**
     * Get the newest questions
     * GET /questions/new.
     * @return Redirect
     */
    public function newest()
    {
        return view('questions.new', ['questions' => Question::orderBy('created_at', 'desc')->paginate(10), 'page_title' => 'New Questions', 'sort' =>'new']);
    }

    /**
     * Insert question in DB
     * POST /questions.
     * @return Redirect
     */
    public function insert()
    {

        // Check for duplicate
        $are_duplicates = QuestionValidation::CheckDuplicateStrict(Request::get('question'), Request::get('tags'));
        if (is_object($are_duplicates)) {
            Session::flash('flash_message', '<P><h3>Question Already Asked</h3></P><P>This question has already been asked by a community member.</P>');

            return Redirect::to('question/'.$are_duplicates->id.'/'.Url::get_slug($are_duplicates->question));
        }

        $question = Question::insert(Auth::user()->id, Request::get('tags'), Request::get('question'));
        Session::flash('flash_message', '<P><h3>Question Added</h3></P><P>You\'ll be notified of new answers or votes immediately!</P>');

        return Redirect::to('question/'.$question->id.'/'.Url::get_slug($question->question));
    }

    /**
     * Get the newest questions
     * GET /questions/new.
     * @param Question $question
     * @return Redirect
     */
    public function edit(Question $question)
    {
        return view('questions.edit', ['question' => $question, 'page_title' => 'Edit Questions']);
    }

    /**
     * Get the newest questions
     * GET /questions/new.
     * @return Redirect
     */
    public function edit_save()
    {
        $id = Request::get('id');
        $question = Request::get('question');

        $q = Question::find($id);
        $q->question = $question;
        $q->save();

        return Redirect::to('question/'.$id.'/'.Url::get_slug($question));
    }
}
