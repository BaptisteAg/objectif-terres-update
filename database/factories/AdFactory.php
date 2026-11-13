<?php

namespace Database\Factories;

use App\Models\Ad;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdFactory extends Factory
{
    protected $model = Ad::class;

    public function definition()
    {
        $randomDateCreated = Carbon::yesterday()->subtract(rand(0, 352).' days');
        $randomDateUpdated = Carbon::make($randomDateCreated)->add(rand(0, 352).' days');

        return [
            'user_pp_id' => User::where('role', '=', 0)->inRandomOrder()->first(),
            'about_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'about_project_content' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            'created_at' => $randomDateCreated,
            'updated_at' => $randomDateUpdated,
        ];
    }
}
