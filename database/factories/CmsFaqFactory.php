<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\CmsFaq;
use Faker\Generator as Faker;

$factory->define(CmsFaq::class, function (Faker $faker) {
    return [
        'content_question' => $faker->sentence($nbWords = 6, $variableNbWords = true).'?',
        'content_answer' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
    ];
});
