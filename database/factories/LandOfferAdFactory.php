<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Building;
use App\Models\House;
use App\Models\Land;
use App\Models\LandOfferAd;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\FactoryBuilder;

FactoryBuilder::macro('disableEvents', function () {
    $this->class::flushEventListeners();

    return $this;
});

$factory->define(LandOfferAd::class, function (Faker $faker) {
    return [
        'accept_use_zip_code' => $faker->boolean,
        'altitude' => $faker->randomNumber(3),
        'surface' => rand(0, 100),
        'price' => rand(1000, 100000),
        'sau_description' => 'Description de la surface agricole utile. Terres arables et prairies permanentes.',
        'water_access' => rand(0, 1),
        // 'is_call_for_application_community' => $faker->boolean,
        // 'is_call_for_application_terre_de_liens' => $faker->boolean,
        // 'is_call_for_application_test_area' => $faker->boolean,
        // 'confirm_price_fermage'=> $faker->boolean,
        // 'is_beneficiary' => $faker->boolean,
        // 'is_activity_transfer' => $faker->boolean,
        // 'building_id' => factory(Building::class),
        // 'house_id' => factory(House::class),
        // 'land_id' => factory(Land::class),
    ];
});
