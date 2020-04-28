<?php

namespace App\Listeners;

use App\Events\AttributionAdEvent;
use Illuminate\Contracts\Queue\ShouldQueue;


class SendAdPublishedDateNotification implements ShouldQueue
{
	private $event;

	/**
	 * Create the event listener.
	 *
	 * @param AttributionAdEvent $event
	 */
	public function __construct(AttributionAdEvent $event)
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
