<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AdStatus;
use App\Models\AttributionAd;
use App\Models\PpType;
use App\Models\RefusalType;
use App\Models\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(AttributionAd::class, function (Faker $faker) {

	$statusArray  = [];
	array_push($statusArray, AdStatus::find(1), AdStatus::find(4));
	$adStatus = $faker->randomElement($statusArray);
	return [
        //'user_advisor_id' => User::where('role', '=', '2')->get()->random()->id,
        'user_moderator_id'=> User::where('role', '=', '1')->get()->random()->id,
		'user_supervisor_id' => User::where('role', '=', '3')->get()->random()->id,
        'to_call_back' => $faker->boolean,
        'short_description' => $faker->text(350),
        'ad_status_id' => $adStatus,
        'pp_type_id' => factory(PpType::class),
        'refusal_type_id' => null,
        'archived_at' => null,
		'published_on' => $adStatus['id'] === 1 ? \Carbon\Carbon::now() : null,
		'created_at'=> Carbon::now()->subDays(rand(0, 9))
    ];
});
