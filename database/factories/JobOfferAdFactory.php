<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\JobOfferAd;
use Faker\Generator as Faker;

$factory->define(JobOfferAd::class, function (Faker $faker) {
    return [
        'experience_farming' => $faker->numberBetween(0, 50),

        //'education_level_id' => EducationLevel::all()->random(),
        //'job_status_id' => JobStatus::all()->random(),
        //'is_beneficiary' => $faker->boolean,
        //'is_offer' => $faker->boolean,
    ];
});
