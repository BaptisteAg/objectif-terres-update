<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Faker\Generator as Faker;
Use App\Models\City;
use App\Models\Country;
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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
		'address' => $faker->address,
		'first_name'=>$faker->firstName,
		'city'=> $faker->city,
		'zip_code_id'=>City::inRandomOrder()->take(1)->get(),
		'country_id'=>Country::inRandomOrder()->take(1)->get(),
        'remember_token' => Str::random(10),
    ];
});
