<?php

namespace App\Jobs;

use App\Models\Ad;
use App\Notifications\BasicNotification;
use App\Notifications\PublishDateExtendBeforeExpirationNotification;
use App\Services\Ads\AdService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyPublishDateExtendBeforeExpiration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $adService;

	/**
	 * Create a new job instance.
	 *
	 * @param AdService $adService
	 */
    public function __construct(AdService $adService)
    {
        $this->adService = $adService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(config("app.is_scheduler_live_mode")) {
            $date = Carbon::now()->subMonths(6)->addDays(7);
        }
        else {
            $date = Carbon::now()->subMinutes(30);
        }
       $soonToExpireAds = $this->adService->findAdsPublishedSince($date);

        logger("Suggesting soon to expire (".$date.") ads owner to extend the date... ".$soonToExpireAds->count()." found.");

        foreach($soonToExpireAds as $ad) {

            try {
                logger("Sending email for ".$ad->title);
                $ad->userPp?->notify(new PublishDateExtendBeforeExpirationNotification($ad));
                if(env('MAIL_HOST', false) === 'smtp.mailtrap.io'){
                    sleep(3);
                    logger("Sleeping 3 seconds");
                }
            }
            catch (\Exception $e) {

            }
        }
    }
}
