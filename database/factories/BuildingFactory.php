<?php



namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Building;

class BuildingFactory extends Factory
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
            'surface' => $this->faker->randomFloat(2, 0, 500),
            'price' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
