<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AttributionAd;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(AttributionAd::class, function (Faker $faker) {

    return [
        'created_at' => Carbon::now()->subDays(rand(0, 9)),
    ];
});
