<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AgriculturalActivity;
use Faker\Generator as Faker;

$factory->define(AgriculturalActivity::class, function (Faker $faker) {
    return [
        'name' => $faker->word()
    ];
});
