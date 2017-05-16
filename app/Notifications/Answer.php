<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
//use Illuminate\Contracts\Queue\ShouldQueue;

use App\Question;
use App\User;

class Answer extends Notification
{
    //use Queueable;

    protected $answer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($answer)
    {
        $this->answer = $answer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $question = Question::find($this->answer['question_id']);
        $user = User::find($this->answer['user_id']);

        return (new MailMessage)
                    ->subject('Someone Answered Your Question')
                    ->greeting('Someone Answered Your Question!')
                    ->line($question->question)
                    ->line($user->name . ' Said')
                    ->line('"'.$this->answer['answer'].'"')
                    ->action('See All Answers', url('/question/'.$question->id .'/'.Question::get_url($question->question)));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        var_dump('toArray()');
        return [
            'workout' => 'TEST'
        ];
    }
}
