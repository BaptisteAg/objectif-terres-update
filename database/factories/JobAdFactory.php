<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ad;
use App\Models\EducationLevel;
use App\Models\JobAd;
use App\Models\JobStatus;
use Faker\Generator as Faker;

$factory->define(JobAd::class, function (Faker $faker) {
    return [
        'title' => $faker->text(10),
        'is_offer' => $faker->boolean,
        'is_beneficiary' => $faker->boolean,
        'experience_farming' => $faker->numberBetween(0, 50),
        'about_content_project' => $faker->text(150),
        'ad_id' => Ad::all()->random()->id,
        'education_level_id' => EducationLevel::all()->random()->id,
        'job_status_id' => JobStatus::all()->random()->id,
    ];
});
