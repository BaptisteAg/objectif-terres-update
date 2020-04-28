<?php

namespace App\Listeners;

use App\Events\AdEvent;
use Illuminate\Contracts\Queue\ShouldQueue;


class SendCompleteAdDataNotification implements ShouldQueue
{
	protected $events;

	/**
	 * Create the event listener.
	 *
	 * @param
	 */
	public function __construct(AdEvent $adEvents)
	{
		$this->events = $adEvents;
	}

	/**
	 * Handle sending alert ad data to complete event.
	 *
	 */
	public function alertAdToComplete()
	{
		$this->events->sendEmailAdsPublishedSince10DaysNotComplete();
	}

}
