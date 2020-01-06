<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\EducationLevel;
use Faker\Generator as Faker;

$factory->define(EducationLevel::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});
