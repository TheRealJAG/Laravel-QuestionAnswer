<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;

use App\Question;
use App\Tag;

class LevelController extends Controller
{

    public function index($level)
    {
        $questions = Question::level($level);
        $tags = Tag::distinct()->orderBy('name', 'asc')->get();
        return view('levels.index', ['page_title' => $level, 'questions' => $questions, 'tags' => $tags]);
    }
}
