<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Research;
use Faker\Generator as Faker;

$factory->define(Research::class, function (Faker $faker) {
    return [
        'sf_id' => $faker->regexify('[A-Za-z0-9]{20}'),
        'name' => $faker->title,
        'surface_min' => $faker->numberBetween(0, 50),
        'surface_max' => $faker->numberBetween(50, 500),
        'has_pics' => $faker->boolean,
        'has_house' => $faker->boolean,
        'price_min' => $faker->numberBetween(0, 50),
        'price_max' => $faker->numberBetween(50, 500),
    ];
});
