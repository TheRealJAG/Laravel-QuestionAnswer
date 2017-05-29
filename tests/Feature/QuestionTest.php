<?php

namespace Tests\Feature;

use App\Events\VoteEvent;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Question;
use App\Answer;
use App\Vote;


class QuestionTest extends TestCase
{

    public $user;
    public $question;
    public $answer;
    public $vote_question;
    public $vote_answer;

    public function homepage_check() {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testApplication()
    {

        // Test inserting a user
        $this->user = factory(User::class)->create();
        if (!$this->user) return false;

        // Test inserting a question with user data
        $this->question = Question::insert($this->user->id, '', 'I\'m just a test question. Please delete me. Thank you!', '');
        if (!$this->question) return false;

        // Test a simple answer to that question
        $this->answer = Answer::insert('I\'m a lonely test comment.', $this->question->id, $this->user->id);
        if (!$this->answer) return false;

        // Test voting on an answer
        $this->vote_answer = Vote::vote($this->user->id, $this->answer->id, 1, 'answer_id');
        if (!$this->answer) return false;

        // Test voting on a question
        $this->vote_question = Vote::vote($this->user->id, $this->question->id, 1, 'question_id');
        if (!$this->vote_question) return false;

        // This test should also produce records in the notifications table
        // See notifications table...



    }









}
