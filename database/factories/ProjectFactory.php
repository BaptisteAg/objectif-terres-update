<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Project;
use App\Models\ProjectStatus;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
		'support_stages_id' => 2,
		'support_states_id' => 2,
		'project_status_id' => 3,
    ];
});
