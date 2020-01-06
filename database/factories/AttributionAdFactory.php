<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AdStatus;
use App\Models\AttributionAd;
use Faker\Generator as Faker;

$factory->define(AttributionAd::class, function (Faker $faker) {
    return [
        'sf_owner_id' => $faker->regexify('[A-Za-z0-9]{20}'),
        'sf_admin_id'=> $faker->regexify('[A-Za-z0-9]{20}'),
        'to_call_back' => $faker->boolean,
        'short_description' => $faker->text(350),
        'ad_status_id' => AdStatus::all()->random()->id,
        'pp_type_id' => AdStatus::all()->random()->id,
        'refusal_type_id' => AdStatus::all()->random()->id,
        'archived_at' => null
    ];
});
