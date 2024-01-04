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
use Symfony\Component\Debug\Exception\FatalThrowableError;

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
        if(config("app.is_scheduler_live_mode")) {
            $before = Carbon::now()->subMonths(12);
            $since = "12 mois";
        }
        else {
            $before = Carbon::now()->subMinutes(10);
            $since = "10 minutes";
        }

		$attributionAds = $this->attributionAdsService
            ->findAllPublishedBefore($before)
            ->filter(fn(AttributionAd $attributionAd) => $attributionAd->ad);

        echo("Unpublishing ads... ".$attributionAds->count()." found.");

        //dd($attributionAds->random()->toArray());

		foreach ($attributionAds as $attributionAd) {

			$data['subject'] = 'Votre annonce a été dépubliée';
			$data['message'] = 'Votre annonce était en ligne depuis '.$since.'. Sans intervention de votre part, nous l\'avons archivée.
			Vous avez toujours la possibilité de la soumettre à nouveau à modération en allant dans votre compte et en cliquant sur "Modifier"';

			$data['url'] = '/annonces/' . $attributionAd->ad->id;

			/** @var User $userToNotify */
            try {
                $userToNotify = $this->userRepository->find($attributionAd->ad->user_pp_id);
                $userToNotify->notify(new AdNotification($data));
            }
            catch (\Exception|\Error $e) {
                echo($e->getMessage());
            }

            $attributionAd->ad_status_id = AdStatus::ARCHIVED_ID;
            $attributionAd->published_on = null;
            $attributionAd->save();

            echo "Unpublished : ".$attributionAd->ad->title . " - " . $attributionAd->ad->created_at."\n";
		}
	}
}
