<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserToUserMessage;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(UserToUserMessage::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random(),
        'content' => $faker->text(500),
    ];
});
