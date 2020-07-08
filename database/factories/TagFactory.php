<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'display' => $faker->word,
        'deleted_at' => $faker->dateTime(),
    ];
});
