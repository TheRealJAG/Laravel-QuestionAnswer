<?php

namespace App\Http\Controllers;

use App\Question;
use App\Tag;

class TagController extends Controller
{
    /**
     * Show new tag questions.
     *
     * @param Tag $tag
     * @return Response
     */
    public function show_new(Tag $tag)
    {
        return view('tag',
                    [
                        'tag_info' => $tag,
                        'questions' => Question::recent_relevant($tag->pluck('name')->toArray()),
                        'page_title' => 'Newest ' . $tag->name . ' Questions',
                        'sort' => 'new',
                        'tags' => Tag::get_tags()
                    ]
        );
    }

    /**
     * Show show top tag questions.
     *
     * @param Tag $tag
     * @return Response
     */
    public function show_top(Tag $tag)
    {
        return view('tag',
                    [
                        'tag_info' => $tag,
                        'questions' => Question::top_relevant($tag->pluck('name')->toArray()),
                        'page_title' => 'Top ' . $tag->name . ' Questions',
                        'sort' => 'top',
                        'tags' => Tag::get_tags()
                    ]
        );
    }

    /**
     * Get the top questions according to votes.
     * @param Tag $tag
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show_most_answered(Tag $tag)
    {
        return view('tag',
                    [
                        'tag_info' => $tag,
                        'questions' => Question::most_answered($tag->pluck('name')->toArray()),
                        'page_title' => 'Most Answered ' . $tag->name . ' Questions',
                        'sort' => 'top_answered'
                    ]
        );
    }

    /**
     * Get unanswered questions according to votes.
     * @param Tag $tag
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show_unanswered(Tag $tag)
    {
        return view('tag',
                    [
                        'tag_info' => $tag,
                        'questions' => Question::unanswered($tag->pluck('name')->toArray()),
                        'page_title' => 'Unanswered ' . $tag->name . ' Questions',
                        'sort' => 'not_answered'
                    ]
        );
    }
}
