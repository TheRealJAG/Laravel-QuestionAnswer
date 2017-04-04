<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Question;
use App\Tag;

class HomeController extends Controller {

    /**
     * Show the homepage
     * @return View
     */
    public function index() {
        $questions = Question::orderBy('created_at', 'desc')->paginate(10);
        $tags = Tag::distinct()->orderBy('name', 'asc')->get();
        return view('index')->with('questions', $questions)->with('tags', $tags)->with('page_title','Q&A - Interview Questions');
    }
}
