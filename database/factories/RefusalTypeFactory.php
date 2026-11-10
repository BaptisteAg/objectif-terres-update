<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\RefusalType;
use Faker\Generator as Faker;

$factory->define(RefusalType::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'content' => $faker->text(200),
    ];
});
