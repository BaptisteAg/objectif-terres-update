<?php



namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\House;

class HouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->randomDigitNotNull,
            'surface' => $this->faker->numberBetween(0, 20000),
            'price' => $this->faker->numberBetween(0, 20000),
        ];
    }
}
