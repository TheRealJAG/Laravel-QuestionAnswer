<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Tag;
use App\Question;

class TagController extends Controller
{
    /**
     * Show new tag questions
     *
     * @param  int  $tag_name
     * @return Response
     */
    public function show_new($tag_name)
    {
        $tag = Tag::where('name', '=', $tag_name)->get();
        $questions = Question::recent_relevant($tag);
        $tag = $tag[0];
        $tags = Tag::distinct()->orderBy('name', 'asc')->get();
        return view('tag', ['tag_info' => $tag, 'questions' => $questions, 'page_title' => 'New ' . $tag->name . ' Interview Questions', 'sort' => 'new', 'tags' => $tags]);
    }

    /**
     * Show show top tag questions
     *
     * @param  int  $tag_name
     * @return Response
     */
    public function show_top($tag_name)
    {
        $tag = Tag::where('name', '=', $tag_name)->get();
        $questions = Question::top_relevant($tag);
        $tag = $tag[0];
        $tags = Tag::distinct()->orderBy('name', 'asc')->get();
        return view('tag', ['tag_info' => $tag, 'questions' => $questions, 'page_title' => 'Top ' . $tag->name . ' Interview Questions', 'sort' => 'top', 'tags' => $tags]);
    }
}
