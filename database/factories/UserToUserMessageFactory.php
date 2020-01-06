<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserToUserMessage;
use Faker\Generator as Faker;

$factory->define(UserToUserMessage::class, function (Faker $faker) {
    return [
        'sf_user_id' => $faker->regexify('[A-Za-z0-9]{20}'),
        'content' => $faker->text(500),
    ];
});
