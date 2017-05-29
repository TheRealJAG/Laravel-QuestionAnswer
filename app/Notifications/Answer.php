<?php

namespace App\Notifications;

use App\Classes\URL;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

use App\Question;
use App\User;
use Carbon;

class Answer extends Notification
{

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
        return ['mail','database'];
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
            ->action('See All Answers', url('/question/'.$question->id .'/'.URL::get_slug($question->question)));
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {
        $question = Question::find($this->answer['question_id']);
        return [
            'question_id' => $question->id,
            'answer_id' => $this->answer['id'],
            'user_id' => $this->answer['user_id'],
            'created_at' => Carbon::now(),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [];
    }
}
