<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Vote::class, function (Faker $faker) {
    return [
        'user_id' => factory(App\User::class),
        'question_id' => factory(App\Question::class),
        'answer_id' => factory(App\Answer::class),
        'vote' => $faker->randomNumber(),
    ];
});
