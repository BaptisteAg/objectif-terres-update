<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use App\Models\User;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $faker = FakerFactory::create('fr_FR');
        $city = City::inRandomOrder()->first();
        $countryFrance = Country::find(75);

        return [
            'name' => $faker->lastName,
            'first_name' => $faker->firstName,
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
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
    }
}
