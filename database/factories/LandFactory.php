<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Land;
use Faker\Generator as Faker;

$factory->define(Land::class, function (Faker $faker) {
    return [
        'area' => $faker->numberBetween(0, 20000),
        'price' => $faker->numberBetween(0, 20000),
        'land_availability' => $faker->dateTime,
        'land_transfer_deadline' => $faker->dateTime
    ];
});
