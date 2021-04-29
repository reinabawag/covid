<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Visitor;
use Faker\Generator as Faker;

$factory->define(Visitor::class, function (Faker $faker) {
    return [
        'name' => $faker->name('male'),
        'temp' => '36',
        'gender' => 'M',
        'age' => '25',
        'address' => $faker->address,
        'purpose' => 'Personal',
        'status' => FALSE,
    ];
});
