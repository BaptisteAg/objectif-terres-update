<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ad;
use App\Models\AdNote;
use Faker\Generator as Faker;

$factory->define(AdNote::class, function (Faker $faker) {
    return [
        'content' => $faker->text(500),
        'sf_user_id' => $faker->regexify('[A-Za-z0-9]{20}'),
        'contact_name' => $faker->name,
        'ad_id' => Ad::all()->random()
    ];
});
