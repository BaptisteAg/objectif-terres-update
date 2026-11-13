<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\FactoryBuilder;

FactoryBuilder::macro('disableEvents', function () {
    $this->class::flushEventListeners();

    return $this;
});

class JobOfferAdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'experience_farming' => $this->faker->numberBetween(0, 50),

            // 'education_level_id' => EducationLevel::all()->random(),
            // 'job_status_id' => JobStatus::all()->random(),
            // 'is_beneficiary' => $this->faker->boolean,
            // 'is_offer' => $this->faker->boolean,
        ];
    }
}
