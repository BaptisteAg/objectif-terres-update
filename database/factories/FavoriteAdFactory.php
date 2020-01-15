<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ad;
use App\Models\FavoriteAd;
use Faker\Generator as Faker;

$factory->define(FavoriteAd::class, function (Faker $faker) {
    return [
        'ad_id' => Ad::all()->random(),
        'sf_id' => $faker->regexify('[A-Za-z0-9]{20}')
    ];
});
