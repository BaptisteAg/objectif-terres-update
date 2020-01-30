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
        'title' => $faker->text(25),
        'is_beneficiary' => $faker->boolean,
        'accept_use_zip_code' => $faker->boolean,
        'is_call_for_application_community' => $faker->boolean,
        'is_call_for_application_terre_de_liens' => $faker->boolean,
        'is_call_for_application_test_area' => $faker->boolean,
        'is_activity_transfer' => $faker->boolean,
        'water_access' => $faker->text(100),
        'altitude' => $faker->randomNumber(4),
        'ad_id' => Ad::all()->random()->id,
        'building_id' => factory(Building::class),
        'house_id' => factory(House::class),
        'land_id' => factory(Land::class),
		'confirm_price_fermage'=> $faker->boolean,
    ];
});
