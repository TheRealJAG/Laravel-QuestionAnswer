<?php

namespace Tests\Feature;

use App\Answer;
use App\Question;
use App\User;
use App\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionTest extends TestCase
{

    use RefreshDatabase;

    public function testQuestion()
    {
        // Test inserting a user
        $this->user = factory(User::class)->create();
        $this->assertSame(1, User::count());

        // Test inserting a question with user data
        $this->question = Question::insert($this->user->id, '', 'I\'m just a test question. Please delete me. Thank you!');
        $this->assertSame(1, Question::count());

        // Test a simple answer to that question
        $this->answer = Answer::insert('I\'m a lonely test comment.', $this->question->id, $this->user->id);
        self::assertSame(1, Answer::count());

        // Test voting on an answer
        $this->vote_answer = Vote::vote($this->user->id, $this->answer->id, 1, 'answer_id');
        if (! $this->answer) {
            return false;
        }

        // Test voting on a question
        $this->vote_question = Vote::vote($this->user->id, $this->question->id, 1, 'question_id');
        if (! $this->vote_question) {
            return false;
        }

        // This test should also produce records in the notifications table
        // See notifications table...
        echo 'Done Testing testQuestion';
    }

    // Test a user creation and all user pages.
    public function testUser()
    {
        $this->user = factory(User::class)->create();
        $this->assertSame(1, User::count());

        $response = $this->get('/user/'.$this->user->id);
        $response->assertStatus(200);

        $response = $this->get('/user/'.$this->user->id.'/questions');
        $response->assertStatus(200);

        $response = $this->get('/user/'.$this->user->id.'/answers');
        $response->assertStatus(200);
        echo 'Done Testing testUser';
    }
}
