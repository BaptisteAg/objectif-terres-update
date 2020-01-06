<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Document;
use Faker\Generator as Faker;

$factory->define(Document::class, function (Faker $faker) {
    return [
        'path' => $faker->image('public/storage', 640, 320),
        'type_document' => $faker->fileExtension
    ];
});
