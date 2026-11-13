<?php



namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Research;
use App\Models\User;

class ResearchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random(),
            'name' => $this->faker->title,
            'surface_min' => $this->faker->numberBetween(0, 50),
            'surface_max' => $this->faker->numberBetween(50, 500),
            'has_pics' => $this->faker->boolean,
            'has_house' => $this->faker->boolean,
            'price_min' => $this->faker->numberBetween(0, 50),
            'price_max' => $this->faker->numberBetween(50, 500),
            'ad_type' => 'landOfferAd',

        ];
    }
}
