<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PpType;
use Faker\Generator as Faker;

$factory->define(PpType::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
