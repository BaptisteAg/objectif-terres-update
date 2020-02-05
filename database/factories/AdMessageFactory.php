<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ad;
use App\Models\AdMessage;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(AdMessage::class, function (Faker $faker) {
    return [
        'content' => $faker->text(250),
        'user_id' => User::all()->random(),
        'ad_id' => Ad::all()->random(),
    ];
});
