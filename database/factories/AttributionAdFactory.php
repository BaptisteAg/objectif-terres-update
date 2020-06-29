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

	return [
        'to_call_back' => $faker->boolean,
        'short_description' => $faker->text(350),
		'created_at'=> Carbon::now()->subDays(rand(0, 9))
    ];
});
