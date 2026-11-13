<?php



namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\AttributionAd;
use Carbon\Carbon;

class AttributionAdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'created_at' => Carbon::now()->subDays(rand(0, 9)),
        ];
    }
}
