<?php

namespace Database\Factories;

use App\Models\InstallationType;
use App\Models\OfferGenre;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\FactoryBuilder;

FactoryBuilder::macro('disableEvents', function () {
    $this->class::flushEventListeners();

    return $this;
});

class LandSeekAdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $surfaceMin = rand(0, 50);

        return [
            'is_bio' => $this->faker->boolean,
            'production_type_add' => $this->faker->text(60),
            // 'has_farm_buildings' => $this->faker->boolean,
            // 'has_houses' => $this->faker->boolean,
            // 'rent_min' => $this->faker->randomFloat(4),
            // 'rent_max' => $this->faker->randomFloat(4),
            // 'offer_genre_id' => OfferGenre::all()->random(),
            'experience_farming' => implode("\n", $this->faker->paragraphs()),
            'surface_range_min' => $surfaceMin,
            'surface_range_max' => $surfaceMin + rand(0, 50),
            'installation_type_id' => InstallationType::inRandomOrder()->take(1)->first(),
        ];
    }
}
