<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OfferGenre;
use Faker\Generator as Faker;

$factory->define(OfferGenre::class, function (Faker $faker) {
    return [
        'name' => $faker->word()
    ];
});
