<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQnaSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('user_id');
            $table->string('question');
            $table->string('level')->default('Beginner');
            $table->boolean('solved')->default(false);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('user_id');
            $table->foreignId('question_id');
            $table->text('answer');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('question_id')->references('id')->on('questions');
        });

        Schema::create('votes', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('user_id');
            $table->foreignId('question_id')->nullable();
            $table->foreignId('answer_id')->nullable();
            $table->integer('vote');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('question_id')->references('id')->on('questions');
            $table->foreign('answer_id')->references('id')->on('answers');
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->string('display');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('question_tag', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('tag_id');
            $table->foreignId('question_id');
            $table->timestamps();
            $table->foreign('tag_id')->references('id')->on('tags');
            $table->foreign('question_id')->references('id')->on('questions');
            $table->unique(['tag_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_tag');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('votes');
        Schema::dropIfExists('answers');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('users');
    }
}
