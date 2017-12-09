<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQnaSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('users', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('questions', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('question');
            $table->string('level')->default('Beginner');
            $table->boolean('solved')->default(false);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('answers', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->text('answer');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('question_id')->references('id')->on('questions');
        });

        Schema::create('votes', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('question_id')->nullable()->unsigned();
            $table->integer('answer_id')->nullable()->unsigned();
            $table->integer('vote');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('question_id')->references('id')->on('questions');
            $table->foreign('answer_id')->references('id')->on('answers');
        });

        Schema::create('tags', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('display');
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('tags_questions', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('tag_id')->unsigned();
            $table->integer('question_id')->unsigned();
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
        Schema::dropIfExists('tags_questions');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('votes');
        Schema::dropIfExists('answers');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('users');
    }
}