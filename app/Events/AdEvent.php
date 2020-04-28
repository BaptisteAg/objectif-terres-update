<?php

namespace App\Events;

use App\Services\Ads\AdService;
use App\Services\Threads\ThreadService;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdEvent
{
	protected $service;
	protected $threadService;
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @param AdService $adService
	 * @param ThreadService $threadService
	 */
	public function __construct(AdService $adService, ThreadService $threadService)
	{
		$this->service = $adService;
		$this->threadService = $threadService;
	}



	public function sendEmailAdsPublishedSince10DaysNotComplete()
	{
		$adsPublishedSince10DaysNotComplete = $this->service->findAllAdsPublishedSinceDaysAndNotComplete(10);
		if ($adsPublishedSince10DaysNotComplete->isNotEmpty()) {
			foreach ($adsPublishedSince10DaysNotComplete as $ad) {
				$messageData = [
					'ad_id' => $ad->id,
					'supervisor_id' => $ad->attributionAd->user_supervisor_id,
					'content' => 'Votre annonce est en ligne depuis 10 jours. Compléter les informations de votre annonce pour augmenter vos chances d\'avoir une réponse!'
				];
				$thread = $this->threadService->findThreadAlreadyExist($ad->attributionAd->user_supervisor_id, $ad->id);
				if (isset($thread)) {
					$messageData['thread_id'] = $thread->id;
					$messageData['sender_user_id'] = $ad->attributionAd->user_supervisor_id;
					try {
						$this->threadService->createMessage($messageData);
					} catch (\Throwable $e) {
						echo($e);
					}
				} else {
					try {
						$this->threadService->create($messageData);
					} catch (\Throwable $e) {
					}
				}
			}
		}
	}
}
