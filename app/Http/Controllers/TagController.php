<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Question;

class TagController extends Controller
{
    /**
     * Show new tag questions
     *
     * @param  string  $name
     * @return Response
     */
    public function show_new($name)
    {
        $tag = Tag::select('name')->where('name', '=', $name)->first();

        if (empty($tag))
            abort(404, "Page Not Found");

        return view('tag', ['tag_info' => $tag, 'questions' => Question::recent_relevant($tag->toArray()), 'page_title' => 'Newest ' . $tag->name . ' Questions', 'sort' => 'new', 'tags' => Tag::get_tags()]);
    }

    /**
     * Show show top tag questions
     *
     * @param  string  $name
     * @return Response
     */
    public function show_top($name)
    {
        $tag = Tag::select('name')->where('name', '=', $name)->first();
        return view('tag', ['tag_info' => $tag, 'questions' => Question::top_relevant($tag->toArray()), 'page_title' => 'Top ' . $tag->name . ' Questions', 'sort' => 'top', 'tags' => Tag::get_tags()]);
    }

    /**
     * Get the top questions according to votes
     * @param  string  $name
     * GET /questions/top
     * @return Redirect
     */
    public function show_most_answered($name)
    {
        $tag = Tag::select('name')->where('name', '=', $name)->first();
        $questions = Question::most_answered($tag->toArray());
        return view('tag', ['tag_info' => $tag, 'questions' => $questions, 'page_title' => 'Most Answered ' . $tag->name . ' Questions', 'sort' => 'top_answered']);
    }

    /**
     * Get unanswered questions according to votes
     * @param  string  $name
     * GET /questions/top
     * @return Redirect
     */
    public function show_unanswered($name)
    {
        $tag = Tag::select('name')->where('name', '=', $name)->first();
        $questions = Question::unanswered($tag->toArray());
        return view('tag', ['tag_info' => $tag, 'questions' => $questions, 'page_title' => 'Unanswered ' . $tag->name . ' Questions', 'sort' => 'not_answered']);
    }

}