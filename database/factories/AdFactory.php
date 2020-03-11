<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ad;
use App\Models\AttributionAd;
use App\Models\Project;
use App\Models\User;
use Faker\Factory;
use Faker\Generator as Faker;

$factory->define(Ad::class, function () {
	$faker = Factory::create('fr_FR');
	$randomDateCreated = \Carbon\Carbon::yesterday()->subtract(rand(0,352).' days');
	$randomDateUpdated = \Carbon\Carbon::make($randomDateCreated)->add(rand(0,352).' days');

	return [
        'user_pp_id' => User::all()->random(),
        'user_admin_id' => User::where('role', '>=', '2')->get()->random()->id,
		'about_content' => implode("\n", $faker->paragraphs()),
		'about_project_content' => implode("\n", $faker->paragraphs()),
        'attribution_ad_id' => factory(AttributionAd::class),
		'created_at' => $randomDateCreated,
		'updated_at' => $randomDateUpdated,
    ];
});
