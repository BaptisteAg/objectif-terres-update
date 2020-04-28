<?php

namespace App\Jobs;


use App\Models\User;
use App\Notifications\ResearchNotification;
use App\Repositories\Users\UserRepository;
use App\Services\Researches\ResearchService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyCreationAlertResearch implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	private $researchService;
	private $userRepository;

	/**
	 * Create a new job instance.
	 *
	 * @param ResearchService $researchService
	 * @param UserRepository $userRepository
	 */
	public function __construct(ResearchService $researchService, UserRepository $userRepository)
	{
		$this->researchService = $researchService;
		$this->userRepository = $userRepository;
	}

	/**
	 * Execute the job.
	 *
	 * @param int $researchId
	 * @return void
	 */
	public function handle(int $researchId)
	{
		$research = $this->researchService->find($researchId);
		$research->update(['has_alert' => 1]);
		$data = [
			'url' => $research->url,
			'subject' => 'Création d\'une alerte pour une recherche de projet | Objectif Terres',
			'message'=> 'Une alerte a bien été créée pour une recherche'
		];
		/** @var User $userLogged */
		$userLogged = $this->userRepository->find($research->user_id);
		$userLogged->notify(new ResearchNotification($data));
	}
}