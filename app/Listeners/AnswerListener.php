<?php

namespace App\Listeners;

use App\Events\AnswerEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Notifiable;
use Notification;

use App\User;
use App\Question;
use App\Notifications\Answer;

class AnswerListener
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
     * @param  AnswerEvent  $event
     * @return void
     */
    public function handle(AnswerEvent $event)
    {
        $answer = $event->answer->toArray();
        $question = Question::find($answer['question_id']);
        $user = User::find($question->user_id);
        Notification::send($user, new Answer($answer));
    }
}