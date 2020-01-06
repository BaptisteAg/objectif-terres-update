<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ad;
use App\Models\Building;
use App\Models\House;
use App\Models\Land;
use App\Models\LandOfferAd;
use Faker\Generator as Faker;

$factory->define(LandOfferAd::class, function (Faker $faker) {
    return [
        'is_beneficiary' => $faker->boolean,
        'accept_use_zip_code' => $faker->boolean,
        'is_call_for_application_community' => $faker->boolean,
        'is_call_for_application_terre_de_liens' => $faker->boolean,
        'is_call_for_application_test_area' => $faker->boolean,
        'is_activity_transfer' => $faker->boolean,
        'water_access' => $faker->text(100),
        'altitude' => $faker->randomNumber(4),
        'about_project_content' => $faker->text(800),
        'ad_id' => Ad::all()->random()->id,
        'building_id' => Building::all()->random()->id,
        'house_id' => House::all()->random()->id,
        'land_id' => Land::all()->random()->id,
    ];
});
