<?php

namespace App\Jobs;

use App\Models\AttributionAd;
use App\Models\User;
use App\Notifications\OverdueModerationNotification;
use App\Notifications\AdNotification;
use App\Repositories\Users\UserRepository;
use App\Services\AttributionAds\AttributionAdsService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Notify5MonthsPublishedAd implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	private $attributionAdsService;
	private $userRepository;

	/**
	 * Create a new job instance.
	 *
	 * @param AttributionAdsService $attributionAdsService
	 * @param UserRepository $userRepository
	 */
	public function __construct(AttributionAdsService $attributionAdsService, UserRepository $userRepository)
	{
		$this->attributionAdsService = $attributionAdsService;
		$this->userRepository = $userRepository;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$attributionAds = $this->attributionAdsService->findAllPublishedSince(Carbon::now()->subMonthsWithOverflow(5));
		foreach ($attributionAds as $attributionAd) {
			$data['subject'] = 'Votre annonce arrive bientôt en fin de publication !| Objectif Terres';
			$data['message'] = 'Votre annonce est en ligne depuis 5 mois et va bientôt arriver en fin de publication. Si vous souhaitez continuer à la faire publier, mettez à jour votre annonce ! Sans action de votre part, votre annonce sera archivée.';
			//TODO the url is the link to the modification ad form
			$data['url'] = '/annonces/' . $attributionAd->ad->id;

			/** @var User $userToNotify */
			$userToNotify = $this->userRepository->find($attributionAd->ad->user_pp_id);
			$userToNotify->notify(new AdNotification($data));

		}
	}
}