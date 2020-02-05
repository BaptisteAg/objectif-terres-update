<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ad;
use App\Models\PpToUserMessage;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(PpToUserMessage::class, function (Faker $faker) {
    return [
        'user_sender_id' => User::all()->random(),
        'user_receiver_id' => User::all()->random(),
        'content' => $faker->text,
        'ad_id' => Ad::all()->random(),
    ];
});
