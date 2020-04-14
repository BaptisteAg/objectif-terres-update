<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Faker\Factory;
Use App\Models\City;
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
	$city = City::inRandomOrder()->first();
	$faker = Factory::create('fr_FR');
	return [
        'name' => $faker->lastName,
		'first_name'=>$faker->firstName,
		'email' => $faker->unique()->safeEmail,
		'email_verified_at' => now(),
		'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
		'address' => $faker->address,
		'phone'=>$faker->phoneNumber,
		'civility'=>$faker->numberBetween(1,3),
		'profile'=>$faker->numberBetween(1,5),
		'city'=>$city->name,
		'accept_communication'=>$faker->boolean(20),
		'accept_share_contact_infos' =>$faker->boolean(20),
		'zip_code_id'=> $city->id,
		'country_id'=>75,
        'remember_token' => Str::random(10),
    ];
});
