<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(Label::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->text
    ];
});
