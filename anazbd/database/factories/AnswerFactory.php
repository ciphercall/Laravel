<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Answer;
use App\Models\Question;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'question_id' => Question::all()->random()->id,
        'answer' => $faker->sentence(2),
    ];
});
