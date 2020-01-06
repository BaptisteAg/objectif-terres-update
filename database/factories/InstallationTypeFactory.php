<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\InstallationType;
use Faker\Generator as Faker;

$factory->define(InstallationType::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});
