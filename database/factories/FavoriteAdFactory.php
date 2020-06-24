<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ad;
use App\Models\FavoriteAd;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(FavoriteAd::class, function (Faker $faker) {
    return [
        'ad_id' => Ad::inRandomOrder()->first(),
        'user_id' => User::inRandomOrder()->first(),
    ];
});
