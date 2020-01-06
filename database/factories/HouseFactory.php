<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\House;
use Faker\Generator as Faker;

$factory->define(House::class, function (Faker $faker) {
    return [
        'number' => $faker->randomDigitNotNull,
        'surface' => $faker->numberBetween(0, 20000),
        'price' => $faker->numberBetween(0, 20000)
    ];
});
