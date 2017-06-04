<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function index($id) {
        $user = User::findOrFail($id);

        if (!$user)
            abort(404, "Page Not Found");

        $questions = Question::where('user_id', '=', $id)->take(10)->orderBy('id','DESC')->get();
        $answers = Answer::where('user_id', '=', $id)->take(10)->orderBy('id','DESC')->get();
        return view('user.index')->with('questions',$questions)->with('user',$user)->with('answers',$answers)->with('page_title', $user->name . '');
    }

    public function questions($id) {
        $user = User::findOrFail($id);
        $questions = Question::where('user_id', '=', $id)->orderBy('id','DESC')->paginate(10);
        return view('user.questions')->with('questions',$questions)->with('user',$user)->with('page_title', $user->name . ' Questions');
    }

    public function answers($id) {
        $user = User::findOrFail($id);
        $answers = Answer::where('user_id', '=', $id)->orderBy('id','DESC')->paginate(10);
        return view('user.answers')->with('user',$user)->with('answers',$answers)->with('page_title', $user->name . 'Answers');
    }

    public function participation($id) {
        $user = User::findOrFail($id);
        $questions = User::get_participation($id);
        return view('user.participation')->with('user',$user)->with('questions',$questions)->with('page_title', $user->name . 'Answers');
    }

    public function notifications($id) {

        if (!isset(Auth::user()->id))
            abort(401, "Unauthorized");

        if(Auth::user()->id == $id) {
            $user = User::findOrFail($id);
            return view('user.notifications')->with('user',$user)->with('user',$user)->with('page_title', $user->name . 'Notifications');
        } else {
            abort(401, "Unauthorized");
        }
        
    }
}