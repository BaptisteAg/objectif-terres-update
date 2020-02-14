<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ad;
use App\Models\Message;
use App\Models\User;
use App\Models\Thread;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
	return [
		'content' => $faker->text(250),
		'sender_user_id' => User::all()->random(),
		'receiver_user_id' => User::all()->random(),
		'thread_id' => Thread::all()->random(),
	];
});
