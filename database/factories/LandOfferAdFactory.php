<?php

namespace Database\Factories;

use App\Models\Building;
use App\Models\House;
use App\Models\Land;
use Illuminate\Database\Eloquent\Factories\Factory;

class LandOfferAdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'accept_use_zip_code' => $this->faker->boolean(),
            'altitude' => $this->faker->randomNumber(3),
            'surface' => rand(0, 100),
            'price' => rand(1000, 100000),
            'sau_description' => 'Description de la surface agricole utile. Terres arables et prairies permanentes.',
            'water_access' => rand(0, 1),
            // 'is_call_for_application_community' => $this->faker->boolean(),
            // 'is_call_for_application_terre_de_liens' => $this->faker->boolean(),
            // 'is_call_for_application_test_area' => $this->faker->boolean(),
            // 'confirm_price_fermage'=> $this->faker->boolean(),
            // 'is_beneficiary' => $this->faker->boolean(),
            // 'is_activity_transfer' => $this->faker->boolean(),
            // 'building_id' => factory(Building::class),
            // 'house_id' => factory(House::class),
            // 'land_id' => factory(Land::class),
        ];
    }
}
