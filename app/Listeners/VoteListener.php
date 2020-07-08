<?php

namespace App\Listeners;

use App\Events\VoteEvent;
use App\Notifications\Vote;
use App\Question;
use App\User;
use Illuminate\Notifications\Notifiable;
use Notification;

class VoteListener
{
    use Notifiable;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  VoteEvent  $event
     * @return void
     */
    public function handle(VoteEvent $event)
    {
        $vote = $event->vote->toArray();
        if (isset($vote['question_id'])) {
            $question = Question::find($vote['question_id']);
            $user = User::find($question->user_id);
            Notification::send($user, new Vote($vote));
        }
    }
}
