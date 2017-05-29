<?php

namespace App\Listeners;

use App\Events\VoteEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Notifiable;
use Notification;

use App\User;
use App\Question;
use App\Notifications\Vote;
use Illuminate\Support\Facades\Log;

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
