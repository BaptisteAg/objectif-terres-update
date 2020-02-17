<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Models\Ad;
use App\Models\Thread;
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
	return [
		'title' => $faker->text(250),
		'ad_id' => Ad::all()->random(),
	];
});
