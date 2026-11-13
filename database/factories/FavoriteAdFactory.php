<?php

namespace Database\Factories;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
