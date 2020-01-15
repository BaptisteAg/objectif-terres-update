<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ad;
use App\Models\AdMessage;
use Faker\Generator as Faker;

$factory->define(AdMessage::class, function (Faker $faker) {
    return [
        'content' => $faker->text(250),
        'sf_sender_id' => $faker->regexify('[A-Za-z0-9]{20}'),
        'ad_id' => Ad::all()->random(),
    ];
});
