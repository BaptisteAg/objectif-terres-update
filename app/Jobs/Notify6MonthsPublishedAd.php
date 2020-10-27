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

class Notify6MonthsPublishedAd implements ShouldQueue
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
		$attributionAds = $this->attributionAdsService->findAllPublishedSince(Carbon::now()->subDays(173));
		foreach ($attributionAds as $attributionAd) {
			$data['subject'] = 'Dans 7 jours : expiration de votre annonce';
			$data['message'] = "Il y a bientôt 6 mois que l'annonce '".$attributionAd->ad->title."' que vous avez déposée sur Objectif Terres est en ligne.\n
			Nous espérons que ce service a répondu à votre besoin.\n
			Sans action de votre part d'ici 7 jours, cette annonce ne sera plus visible sur notre site.\n
			Pour reconduire votre annonce sans modification pour une durée de 6 mois : \n";
			$data["action"] =  ["Etendre l'annonce", route("ads.extend", [$attributionAd->ad->id])];

			$data['additional_message'] = "Pour modifier votre annonce :";
			$data["additional_action"] =  ["Modifier l'annonce", route("ads.edit", [$attributionAd->ad->id])];



			/** @var User $userToNotify */
			$userToNotify = $this->userRepository->find($attributionAd->ad->user_pp_id);
			$userToNotify->notify(new AdNotification($data));

		}
	}
}