<?php

namespace App\Listeners;

use App\Events\AttributionAdEvents;
use Illuminate\Contracts\Queue\ShouldQueue;


class SendAdPublishedDateNotification implements ShouldQueue
{
	private $event;

	/**
	 * Create the event listener.
	 *
	 * @param AttributionAdEvents $event
	 */
	public function __construct(AttributionAdEvents $event)
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
