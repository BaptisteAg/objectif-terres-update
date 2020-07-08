<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\SupportStage;
use App\Models\SupportState;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
		'support_stage_id' => SupportStage::FIRST_CONTACT_ID,
		'support_state_id' => SupportState::TO_HANDLE_ID,
		'project_status_id' => ProjectStatus::EMERGING_ID,
    ];
});
