<?php

namespace App\Listeners;

use App\Events\Research;
use Illuminate\Contracts\Queue\ShouldQueue;


class SendResearchNotification implements ShouldQueue
{
	private $event;

	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct(Research $event)
	{
		$this->event = $event;
	}

	/**
	 * Handle the creation of alert research event.
	 *
	 * @param int $id
	 * @return void
	 */
	public function newAlertResearch(int $id)
	{
		$this->event->createAlert($id);
	}

	/**
	 * Handle sending alert research event.
	 *
	 */
	public function alertResearch()
	{
		$this->event->sendAlert();
	}

}
