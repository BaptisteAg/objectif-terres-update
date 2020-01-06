<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AdStatus;
use Faker\Generator as Faker;

$factory->define(AdStatus::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});
