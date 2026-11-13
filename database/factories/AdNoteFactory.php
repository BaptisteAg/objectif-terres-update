<?php



namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ad;
use App\Models\AdNote;
use App\Models\User;

class AdNoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value' => $this->faker->text(500),
            'user_id' => User::all()->random(),
            'contact_name' => $this->faker->name,
            'ad_id' => Ad::inRandomOrder()->first(),
        ];
    }
}
