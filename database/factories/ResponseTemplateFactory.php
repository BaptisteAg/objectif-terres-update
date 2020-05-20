<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ResponseTemplate;
use Faker\Generator as Faker;

$factory->define(ResponseTemplate::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'content' => $faker->text(50)
    ];
});
