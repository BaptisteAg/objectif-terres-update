<?php

namespace App\Listeners;

use App\Events\ModerationEvents;
use Illuminate\Contracts\Queue\ShouldQueue;


class SendModerationNotification implements ShouldQueue
{
	private $event;

	/**
	 * Create the event listener.
	 *
	 * @param ModerationEvents $event
	 */
	public function __construct(ModerationEvents $event)
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
