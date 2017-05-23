<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

use App\Vote;

class VoteController extends Controller
{
    public function vote_question()
    {
        return Response::json(Vote::vote(Auth::id(), Request::get('question_id'), Request::get('vote'), 'question_id'));
    }

    public function vote_answer()
    {
        return Response::json(Vote::vote(Auth::id(), Request::get('answer_id'), Request::get('vote'), 'answer_id'));
    }
}
