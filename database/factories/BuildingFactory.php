<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Building;
use Faker\Generator as Faker;

$factory->define(Building::class, function (Faker $faker) {
    return [
        'number' => $faker->randomDigitNotNull,
        'surface' => $faker->randomFloat(2, 0, 500),
        'price' => $faker->numberBetween(0, 1000)
    ];
});
