<?php

namespace App\Listeners;

use App\Events\AttributionAd;
use Illuminate\Contracts\Queue\ShouldQueue;


class SendAdPublishedDateNotification implements ShouldQueue
{
	private $event;

	/**
	 * Create the event listener.
	 *
	 * @param AttributionAd $event
	 */
	public function __construct(AttributionAd $event)
	{
		$this->event = $event;
	}

	/**
	 * Handle sending alert moderation event.
	 *
	 */
	public function alertPublishedOnDate()
	{
		$this->event->sendAlert3Months();
		$this->event->sendAlert5Months();
	}

}
