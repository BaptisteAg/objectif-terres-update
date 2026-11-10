<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProductionGenre;
use Faker\Generator as Faker;

$factory->define(ProductionGenre::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
