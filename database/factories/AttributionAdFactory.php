<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AdStatus;
use App\Models\AttributionAd;
use App\Models\PpType;
use App\Models\RefusalType;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(AttributionAd::class, function (Faker $faker) {
    return [
        'user_owner_id' => User::all()->random(),
        'user_moderator_id'=> User::all()->random(),
        'to_call_back' => $faker->boolean,
        'short_description' => $faker->text(350),
        'ad_status_id' => AdStatus::all()->random(),
        'pp_type_id' => factory(PpType::class),
        'refusal_type_id' => factory(RefusalType::class),
        'archived_at' => null
    ];
});
