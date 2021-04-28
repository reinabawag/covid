<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Answer;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    static $question = 1;
    return [
        'answer' => 'No',
        'question_id' => $question++,
    ];
});
