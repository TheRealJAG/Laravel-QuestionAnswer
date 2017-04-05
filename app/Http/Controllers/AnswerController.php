<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

use App\Answer;

class AnswerController extends Controller
{

    /**
     * Insert an answer
     * POST /answers
     * @return Response
     */
    public function insert()
    {
        Answer::insert(Request::get('answer'),Request::get('question_id'),Auth::user()->id);
        return Redirect::to('question/'.Request::get('question_id').'/'.Request::get('question_url'));

    }

    /**
     * Update the answer from jquery
     * @return Response
     */
    public function update() {
        $answer = Answer::update_answer(Request::get('pk'),Request::get('value'));
        if($answer)
            return Response::json(array('status'=>1));
        else
            return Response::json(array('status'=>0));
    }

}
