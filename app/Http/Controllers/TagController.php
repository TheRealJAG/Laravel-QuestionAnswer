<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Tag;
use App\Question;

class TagController extends Controller
{
    /**
     * Show the tag
     *
     * @param  int  $tag_name
     * @return Response
     */
    public function show($tag_name)
    {
        $tag = Tag::where('name', '=', $tag_name)->get();
        $questions = Question::recent_relevant($tag);
        $tag = $tag[0];
        $tags = Tag::distinct()->orderBy('name', 'asc')->get();
        return view('tag')->with('tag_info',$tag)->with('questions',$questions)->with('page_title', 'New ' . $tag->name . ' Interview Questions')->with('sort','new')->with('tags',$tags);
    }

    /**
     * Show the question
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
        return view('tag')->with('tag_info',$tag)->with('questions',$questions)->with('page_title', 'Top ' . $tag->name . ' Interview Questions')->with('sort','top')->with('tags',$tags);
    }
}
