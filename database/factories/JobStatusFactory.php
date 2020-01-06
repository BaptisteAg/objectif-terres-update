<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\JobStatus;
use Faker\Generator as Faker;

$factory->define(JobStatus::class, function (Faker $faker) {
    return [
        'name' => $faker->word()
    ];
});
