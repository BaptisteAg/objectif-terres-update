<?php

namespace App\Jobs;

use App\Models\AttributionAd;
use App\Models\User;
use App\Notifications\OverdueModerationNotification;
use App\Notifications\ResearchNotification;
use App\Repositories\Users\UserRepository;
use App\Services\Researches\ResearchService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyNewResultsResearch implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	private $researchService;
	private $userRepository;

	/**
	 * Create a new job instance.
	 *
	 * @param UserRepository $userRepository
	 * @param ResearchService $researchService
	 */
	public function __construct(UserRepository $userRepository, ResearchService $researchService)
	{
		$this->userRepository = $userRepository;
		$this->researchService = $researchService;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$researchesWithNewAds = $this->researchService->findNewRelatedAds();
		if (count($researchesWithNewAds)) {
			foreach ($researchesWithNewAds as $idResearch => $ad) {
				$research = $this->researchService->find($idResearch);
				$data = [
					'url' => $research->url,
					'subject' => 'De nouvelles annonces correspondantes à votre recherche ont été publiées | Objectif Terres',
					'message' => 'De nouvelles annonces concernant votre recherche ont été publiées, consulter les dernières annonces correspondantes à votre recherche !'
				];

				/** @var User $userToNotify */
				$userToNotify = $this->userRepository->find($research->user_id);
				$userToNotify->notify(new ResearchNotification($data));
			}
		}
	}
}