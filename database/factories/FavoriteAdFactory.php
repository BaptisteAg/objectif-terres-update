<?php



namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ad;
use App\Models\FavoriteAd;
use App\Models\User;

class FavoriteAdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ad_id' => Ad::inRandomOrder()->first(),
            'user_id' => User::inRandomOrder()->first(),
        ];
    }
}
