<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SurfaceRange;
use Faker\Generator as Faker;

$factory->define(SurfaceRange::class, function (Faker $faker) {
    return [
        'surface' => '[' . $faker->randomDigit . ' - ' . $faker->randomDigit . ']'
    ];
});
