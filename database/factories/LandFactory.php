<?php



namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Land;

class LandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'area' => $this->faker->numberBetween(0, 20000),
            'price' => $this->faker->numberBetween(0, 20000),
            'land_availability' => $this->faker->dateTime,
            'land_transfer_deadline' => $this->faker->dateTime,
        ];
    }
}
