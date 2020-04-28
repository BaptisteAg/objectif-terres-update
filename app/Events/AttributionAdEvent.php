<?php

namespace App\Events;

use App\Notifications\PublishedAdNotification;
use App\Services\AttributionAds\AttributionAdsService;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class AttributionAdEvent
{
	protected $service;
	use Dispatchable, InteractsWithSockets, SerializesModels;


	/**
	 * Create a new event instance.
	 *
	 * @param AttributionAdsService $attributionAd
	 */
	public function __construct(AttributionAdsService $attributionAd)
	{
		$this->service = $attributionAd;
	}

	/**
	 * Send an email when the ad is published since 3 months
	 *
	 * @param int
	 */
	public function sendAlert3Months()
	{
		$attributionAds = $this->service->findAllPublishedSinceMonths(3);
		foreach ($attributionAds as $attributionAd) {
			$data['subject'] = 'Compléter votre annonce !| Objectif Terres';
			$data['message'] = 'Votre annonce est en ligne depuis 3 mois. Compléter les informations de votre annonce pour augmenter vos chances de contacts !';
			//TODO the url is the link to the modification ad form
			$data['url'] = '/annonces/' . $attributionAd->ad->id;
			Notification::route('mail', $attributionAd->ad->userPp->email)
				->notify(new PublishedAdNotification($data));
		}
	}

	/**
	 * Send an email when the ad is published since 5 months
	 * @param int
	 */
	public function sendAlert5Months()
	{
		$attributionAds = $this->service->findAllPublishedSinceMonths(5);
		foreach ($attributionAds as $attributionAd) {
			$data['subject'] = 'Votre annonce arrive bientôt en fin de publication !| Objectif Terres';
			$data['message'] = 'Votre annonce est en ligne depuis 5 mois et va bientôt arriver en fin de publication. Si vous souhaitez continuer à la faire publier, mettez à jour votre annonce ! Sans action de votre part, votre annonce sera archivée.';
			//TODO the url is the link to the modification ad form
			$data['url'] = '/annonces/' . $attributionAd->ad->id;
			Notification::route('mail', $attributionAd->ad->userPp->email)
				->notify(new PublishedAdNotification($data));
		}

	}

}
