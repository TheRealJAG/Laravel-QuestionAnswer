<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;

use App\Question;
use App\Tag;

class HomeController extends Controller {

    /**
     * Show the homepage
     * @return View
     */
    public function index() {
        $questions = Question::orderBy('created_at', 'desc')->paginate(10);
        $top = Question::top_limited(3);
        return view('index')->with('questions', $questions)->with('top', $top)->with('page_title','Q&A - Interview Questions');
    }

    /**
     * Show the homepage
     * @return View
     */
    public function search() {
        $query =  Input::get('query');
        $questions = Question::search($query);
        return view('search')->with('questions', $questions)->with('page_title','Search')->with('query',$query);
    }
}
