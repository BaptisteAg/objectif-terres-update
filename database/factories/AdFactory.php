<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ad;
use App\Models\AttributionAd;
use App\Models\Project;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Ad::class, function (Faker $faker) {
    return [
        'user_pp_id' => User::all()->random(),
        'user_admin_id' => User::all()->random(),
        'is_draft' => $faker->boolean,
        'title' => $faker->text(25),
        'about_content' => $faker->text(500),
        'about_project_content' => $faker->text(750),
        'attribution_ad_id' => factory(AttributionAd::class),
        'project_id' => factory(Project::class)
    ];
});
