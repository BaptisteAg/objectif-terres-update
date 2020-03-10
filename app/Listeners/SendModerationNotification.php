<?php

namespace App\Listeners;

use App\Events\Moderation;
use Illuminate\Contracts\Queue\ShouldQueue;


class SendModerationNotification implements ShouldQueue
{
	private $event;

	/**
	 * Create the event listener.
	 *
	 * @param Moderation $event
	 */
	public function __construct(Moderation $event)
	{
		$this->event = $event;
	}

	/**
	 * Handle sending alert moderation event.
	 *
	 */
	public function alertModeration()
	{
		$this->event->sendAlert();
	}

}
