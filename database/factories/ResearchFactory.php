<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Research;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Research::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random(),
        'name' => $faker->title,
        'surface_min' => $faker->numberBetween(0, 50),
        'surface_max' => $faker->numberBetween(50, 500),
        'has_pics' => $faker->boolean,
        'has_house' => $faker->boolean,
        'price_min' => $faker->numberBetween(0, 50),
        'price_max' => $faker->numberBetween(50, 500),
		'ad_type' => 'landOfferAd'

    ];
});
