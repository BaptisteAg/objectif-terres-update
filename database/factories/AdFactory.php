<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ad;
use App\Models\AttributionAd;
use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(Ad::class, function (Faker $faker) {
    return [
        'sf_pp_id' => $faker->regexify('[A-Za-z0-9]{20}'),
        'sf_admin_id' => $faker->regexify('[A-Za-z0-9]{20}'),
        'is_draft' => $faker->boolean,
        'about_content' => $faker->text(500),
        'about_project_content' => $faker->text(750),
        'attribution_ad_id' => factory(AttributionAd::class),
        'project_id' => factory(Project::class)
    ];
});
