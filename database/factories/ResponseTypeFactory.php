<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ResponseType;
use Faker\Generator as Faker;

$factory->define(ResponseType::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'content' => $faker->text(50)
    ];
});
