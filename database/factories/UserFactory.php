<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

namespace Database\Factories;

use App\Models\City;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function () {
    $faker = Factory::create('fr_FR');
    $city = City::inRandomOrder()->first();
    $countryFrance = \App\Models\Country::find(75);

    return [
        'name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'street' => $faker->streetAddress,
        'phone' => $faker->phoneNumber,
        'civility' => $faker->numberBetween(1, 3),
        'profile' => $faker->numberBetween(1, 5),
        'city' => $city ? $city->name : $faker->city,
        'accept_communication' => $faker->boolean(20),
        'accept_share_contact_infos' => $faker->boolean(20),
        'zip_code_id' => $city ? $city->id : null,
        'country_id' => $countryFrance ? $countryFrance->id : null,
        'remember_token' => Str::random(10),
    ];
});
