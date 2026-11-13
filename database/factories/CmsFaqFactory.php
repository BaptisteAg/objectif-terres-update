<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CmsFaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content_question' => $this->faker->sentence($nbWords = 6, $variableNbWords = true).'?',
            'content_answer' => $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        ];
    }
}
