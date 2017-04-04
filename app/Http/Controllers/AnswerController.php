<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

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
        Answer::insert();
        return Redirect::to('question/'.Request::get('question_id').'/'.Request::get('question_url'));

    }

    /**
     * Update the answer from jquery
     * @return Response
     */
    public function update() {
        $answer = Answer::update_answer();
        if($answer)
            return Response::json(array('status'=>1));
        else
            return Response::json(array('status'=>0));
    }

}
