<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ad;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Eloquent\FactoryBuilder;

FactoryBuilder::macro('disableEvents', function () {
    $this->class::flushEventListeners();

    return $this;
});

$factory->define(Ad::class, function () {
    $faker = Factory::create('fr_FR');
    $randomDateCreated = \Carbon\Carbon::yesterday()->subtract(rand(0, 352).' days');
    $randomDateUpdated = \Carbon\Carbon::make($randomDateCreated)->add(rand(0, 352).' days');

    return [
        'user_pp_id' => User::where('role', '=', 0)->inRandomOrder()->first(),
        'about_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        'about_project_content' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        'created_at' => $randomDateCreated,
        'updated_at' => $randomDateUpdated,
    ];
});
