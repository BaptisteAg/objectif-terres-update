<?php

namespace App\Jobs;

use App\Models\AdStatus;
use App\Models\AttributionAd;
use App\Models\User;
use App\Notifications\AdNotification;
use App\Repositories\Users\UserRepository;
use App\Services\AttributionAds\AttributionAdsService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UnpublishOldAds implements ShouldQueue
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
     * @throws \Exception
     */
	public function handle()
	{
        $months = 12;

		$attributionAds = $this->attributionAdsService
            ->findAllPublishedSince(Carbon::now()->subMonths($months))
            ->filter(fn(AttributionAd $attributionAd) => $attributionAd->ad);

        echo("Unpublishing ads... ".$attributionAds->count()." found.");

		foreach ($attributionAds as $attributionAd) {

			$data['subject'] = 'Votre annonce a été dépubliée';
			$data['message'] = 'Votre annonce était en ligne depuis '.$months.' mois. Sans intervention de votre part, nous l\'avons archivée.
			Vous avez toujours la possibilité de la soumettre à nouveau à modération en allant dans votre compte et en cliquant sur "Modifier"';

			$data['url'] = '/annonces/' . $attributionAd->ad->id;

			/** @var User $userToNotify */
			$userToNotify = $this->userRepository->find($attributionAd->ad->user_pp_id);
			$userToNotify->notify(new AdNotification($data));

            $attributionAd->ad_status_id = AdStatus::ARCHIVED_ID;
            $attributionAd->published_on = null;
            $attributionAd->save();
		}
	}
}
