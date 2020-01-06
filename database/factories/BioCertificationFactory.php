<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BioCertification;
use Faker\Generator as Faker;

$factory->define(BioCertification::class, function (Faker $faker) {
    return [
        'name' => $faker->title
    ];
});
