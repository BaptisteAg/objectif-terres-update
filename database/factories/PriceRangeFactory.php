<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PriceRange;
use Faker\Generator as Faker;

$factory->define(PriceRange::class, function (Faker $faker) {
    return [
        'price' => '[' . $faker->randomDigit . ' - ' . $faker->randomDigit . ']'
    ];
});
