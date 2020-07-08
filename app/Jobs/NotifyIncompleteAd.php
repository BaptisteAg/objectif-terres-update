<?php

namespace App\Jobs;

use App\Services\Ads\AdService;
use App\Services\Threads\ThreadService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyIncompleteAd implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	private $adService;
	private $threadService;

	/**
	 * Create a new job instance.
	 *
	 * @param AdService $adService
	 * @param ThreadService $threadService
	 */
	public function __construct(AdService $adService, ThreadService $threadService)
	{
		$this->adService = $adService;
		$this->threadService = $threadService;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$ads = $this->adService->findAllAdsNotCompleteAndPublishedSince(Carbon::now()->subDays(10));

        logger("Notifying published but incomplete ads owners and suggesting editing... ".$ads->count()." found.");

        foreach ($ads as $ad) {
            $messageData = [
                'ad_id' => $ad->id,
                'supervisor_id' => $ad->attributionAd->user_supervisor_id,
                'content' => 'Votre annonce est en ligne depuis 10 jours. Complétez les informations de votre annonce pour augmenter vos chances d\'avoir une réponse!'
            ];
            $threads = $this->threadService->findThreadAlreadyExist($ad->attributionAd->user_supervisor_id, $ad->id);
            if (count($threads)) {
                foreach ($threads as $thread) {
                    $messageData['thread_id'] = $thread->id;
                    $messageData['sender_user_id'] = $ad->attributionAd->user_supervisor_id;
                    try {
                        $this->threadService->createMessage($messageData);
                    } catch (\Throwable $e) {
                        echo($e);
                    }
                }
            } else {
                try {
                    $this->threadService->create($messageData);
                } catch (\Throwable $e) {
                    echo($e);
                }
            }
        }

	}
}