<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ad;
use App\Models\PpToUserMessage;
use Faker\Generator as Faker;

$factory->define(PpToUserMessage::class, function (Faker $faker) {
    return [
        'sf_sender_id' => $faker->regexify('[A-Za-z0-9]{20}'),
        'sf_receiver_id' => $faker->regexify('[A-Za-z0-9]{20}'),
        'content' => $faker->text,
        'ad_id' => Ad::all()->random()->id,
    ];
});
