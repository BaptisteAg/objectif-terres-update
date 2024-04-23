<?php

namespace App\Jobs;

use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\AttributionAd;
use App\Models\User;
use App\Notifications\AdNotification;
use App\Notifications\UnpublishedAdNotification;
use App\Repositories\Users\UserRepository;
use App\Services\AttributionAds\AttributionAdsService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\Output;
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
            $before = Carbon::now()->subMonths(6);
            $since = "6 mois";
        }
        else {
            $before = Carbon::now()->subMinutes(60);
            $since = "60 minutes";
        }

        // Log sql
        ////DB::enableQueryLog();

		$attributionAds = $this->attributionAdsService
            ->findAllPublishedBefore($before)
            ->filter(fn(AttributionAd $attributionAd) => $attributionAd->ad);

        // Log sql
        //$queries = DB::getQueryLog();
        //$formattedQueries = array_map(function ($query) {
        //    return vsprintf(str_replace(['%', '?'], ['%%', '%s'], $query['query']), $query['bindings']);
        //}, $queries);
        //logger(implode("\n", $formattedQueries));

        echo("Unpublishing ads older than ".$before."... ".$attributionAds->count()." found.\n");

        //dd($attributionAds->random()->toArray());

        $progressBar = new ProgressBar(new ConsoleOutput(Output::VERBOSITY_NORMAL), $attributionAds->count());
        $progressBar->setMaxSteps($attributionAds->count());
        $progressBar->start();

		foreach ($attributionAds as $attributionAd) {
			/** @var User $userToNotify */
            try {
                $userToNotify = $this->userRepository->find($attributionAd->ad->user_pp_id);
                $userToNotify->notify(new UnpublishedAdNotification($attributionAd, $since));
            }
            catch (\Exception|\Error $e) {
                echo($e->getMessage() . "\n\n");
            }

            $attributionAd->ad_status_id = AdStatus::ARCHIVED_ID;
            $attributionAd->published_on = null;
            $attributionAd->archived_at = Carbon::now();
            $attributionAd->save();

            echo "Unpublished : ".$attributionAd->ad->title . " - " . $attributionAd->ad->created_at . "\n";
            $progressBar->advance();
            $progressBar->display();
		}

        $progressBar->finish();
	}
}
