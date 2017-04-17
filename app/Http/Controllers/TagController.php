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

            if ($tag->isEmpty())
                abort(404, "Page Not Found");

        $questions = Question::recent_relevant($tag);
        $tag = $tag[0];
        $tags = Tag::distinct()->orderBy('name', 'asc')->get();

        return view('tag', ['tag_info' => $tag, 'questions' => $questions, 'page_title' => 'New ' . $tag->name . ' Questions', 'sort' => 'new', 'tags' => $tags]);
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
        return view('tag', ['tag_info' => $tag, 'questions' => $questions, 'page_title' => 'Top ' . $tag->name . ' Questions', 'sort' => 'top', 'tags' => $tags]);
    }

    /**
     * Get the top questions according to votes
     * GET /questions/top
     * @return Redirect
     */
    public function show_most_answered($tag_name)
    {
        $tag = Tag::where('name', '=', $tag_name)->get();
        $questions = Tag::most_answered($tag);
        $tag = $tag[0];
        $tags = Tag::distinct()->orderBy('name', 'asc')->get();
        return view('tag', ['tag_info' => $tag, 'questions' => $questions, 'page_title' => 'Most Answered ' . $tag->name . ' Questions', 'sort' => 'top_answered', 'tags' => $tags]);
    }

    /**
     * Get the top questions according to votes
     * GET /questions/top
     * @return Redirect
     */
    public function show_unanswered($tag_name)
    {
        $tag = Tag::where('name', '=', $tag_name)->get();
        $questions = Tag::unanswered($tag);
        $tag = $tag[0];
        $tags = Tag::distinct()->orderBy('name', 'asc')->get();
        return view('tag', ['tag_info' => $tag, 'questions' => $questions, 'page_title' => 'Most Answered ' . $tag->name . ' Questions', 'sort' => 'not_answered', 'tags' => $tags]);
    }

}
