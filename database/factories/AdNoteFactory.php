<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ad;
use App\Models\AdNote;
use App\Models\ProjectDataKey;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(AdNote::class, function (Faker $faker) {
    return [
        'value' => $faker->text(500),
        'user_id' => User::all()->random(),
        'contact_name' => $faker->name,
        'ad_id' => Ad::all()->random(),
		'project_data_key_id'=>ProjectDataKey::all()->random(),
    ];
});
