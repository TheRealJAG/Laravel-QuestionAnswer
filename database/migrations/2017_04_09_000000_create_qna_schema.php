<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQnaSchema extends Migration
{
    const SCHEMA = "" ;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $schema =  static::SCHEMA ;

        Schema::create($schema . 'questions', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('question');
            $table->string('level')->default('Beginner');
            $table->boolean('solved')->default(false);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create($schema . 'answers', function(Blueprint $table) use ($schema)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('question_id');
            $table->text('answer');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('question_id')->references('id')->on($schema . 'questions');
        });

        Schema::create($schema . 'votes', function(Blueprint $table) use ($schema)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('question_id')->nullable();
            $table->integer('answer_id')->nullable();
            $table->integer('vote');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('question_id')->references('id')->on($schema . 'questions');
            $table->foreign('answer_id')->references('id')->on($schema . 'answers');
        });

        Schema::create($schema . 'tags', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('display');
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create($schema . 'tags_questions', function(Blueprint $table) use ($schema)
        {
            $table->increments('id');
            $table->integer('tag_id');
            $table->integer('question_id');
            $table->timestamps();
            $table->foreign('tag_id')->references('id')->on($schema . 'tags');
            $table->foreign('question_id')->references('id')->on($schema . 'questions');
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
        $schema = static::SCHEMA ;
        Schema::dropIfExists($schema . 'tags_questions');
        Schema::dropIfExists($schema . 'tags');
        Schema::dropIfExists($schema . 'votes');
        Schema::dropIfExists($schema . 'answers');
        Schema::dropIfExists($schema . 'questions');
    }
}
