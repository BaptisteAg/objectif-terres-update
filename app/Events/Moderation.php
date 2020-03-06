<?php

namespace App\Events;

use App\Notifications\ModerationNotification;
use App\Services\AttributionAds\AttributionAdsService;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class Moderation
{
	private $attributionAdsService;
	use Dispatchable, InteractsWithSockets, SerializesModels;


	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(AttributionAdsService $attributionAdsService)
	{
		$this->attributionAdsService = $attributionAdsService;
	}


	/**
	 * Send an email to every moderator who doesn't moderate an ad submitted since a week
	 *
	 */
	public function sendAlert()
	{
		$adsToModerateByModerators = $this->attributionAdsService->findAllAdsToModerateByModerators();
		foreach ($adsToModerateByModerators as $key => $adsToModerateByModerator) {

			if (count($adsToModerateByModerator) === 0) {
				break;
			}

			$moderatorToNotify = $adsToModerateByModerator->first()->userModerator;
			//if a notification about old ads to moderate exist, we delete it in order to create a new one
			if (!$moderatorToNotify->unreadNotifications->isEmpty()) {
				foreach (($moderatorToNotify->unreadNotifications) as $notification) {
					if ($notification->type === "App\Notifications\ModerationNotification") {
						$notification->delete();
					}
				}
			}

			$messageData = '';
			if ($adsToModerateByModerator->count() <= 1) {
				$messageData = 'Vous avez ' . $adsToModerateByModerator->count() . ' annonce en attente de modération depuis plus de 7 jours !';
			} else {
				$messageData = 'Vous avez ' . $adsToModerateByModerator->count() . ' annonces en attente de modération depuis plus de 7 jours !';
			}
			$adsToModerateByModerator->first()->userModerator->notify(new ModerationNotification($messageData, $adsToModerateByModerator));
		}
	}

}
