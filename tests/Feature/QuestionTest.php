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

    public function testQuestion()
    {
        // Test inserting a user
        $this->user = factory(User::class)->create();
        if (!$this->user) return false;

        // Test inserting a question with user data
        $this->question = Question::insert($this->user->id, '', 'I\'m just a test question. Please delete me. Thank you!');
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
        print "Done Testing testQuestion";
    }

    // Test a user creation and all user pages.
    public function testUser() {
        $this->user = factory(User::class)->create();
        if (!$this->user) return false;

        $response = $this->call('GET', '/user/'.$this->user->id);
        $this->assertEquals(200, $response->status());

        $response = $this->call('GET', '/user/'.$this->user->id.'/questions');
        $this->assertEquals(200, $response->status());

        $response = $this->call('GET', '/user/'.$this->user->id.'/answers');
        $this->assertEquals(200, $response->status());
        print "Done Testing testUser";
    }


}
