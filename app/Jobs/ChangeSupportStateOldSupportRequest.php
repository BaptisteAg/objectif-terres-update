<?php

namespace App\Jobs;

use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\SupportState;
use App\Services\Projects\ProjectService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChangeSupportStateOldSupportRequest implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	private $projectService;


	/**
	 * Create a new job instance.
	 *
	 * @param ProjectService $projectService
	 */
	public function __construct(ProjectService $projectService)
	{
		$this->projectService = $projectService;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$projects = $this->projectService->findAllBySupportStateAndSinceNumberOfDays(SupportState::PENDING_ID,1);
		foreach ($projects as $project) {
			/** @var Project $project */
			$project->support_state_id = SupportState::TO_ARCHIVE_ID;
			$project->save();
		}
	}
}
