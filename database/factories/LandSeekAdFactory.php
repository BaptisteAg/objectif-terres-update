<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ad;
use App\Models\InstallationType;
use App\Models\LandSeekAd;
use App\Models\OfferGenre;
use Faker\Generator as Faker;

$factory->define(LandSeekAd::class, function (Faker $faker) {
	$surfaceMin = rand(0, 50);
    return [
        'is_bio' => $faker->boolean,
        'production_type_add' => $faker->text(60),
        //'has_farm_buildings' => $faker->boolean,
        //'has_houses' => $faker->boolean,
        //'rent_min' => $faker->randomFloat(4),
        //'rent_max' => $faker->randomFloat(4),
        //'offer_genre_id' => OfferGenre::all()->random(),
        'experience_farming' => implode("\n", $faker->paragraphs()),
		'surface_range_min' => $surfaceMin,
		'surface_range_max' => $surfaceMin+rand(0,50),
        'installation_type_id' => InstallationType::inRandomOrder()->take(1)->first(),
    ];
});
