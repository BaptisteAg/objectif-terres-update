<?php

namespace App\Http\Composers;


use App\Models\Thread;
use App\Services\Threads\ThreadService;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class MessagesNotificationHeaderComposer
{
	/**
	 * @var ThreadService
	 */
	protected $service;


	/**
	 * ThreadsController constructor.
	 * @param ThreadService $service
	 */
	public function __construct(ThreadService $service)
	{
		$this->service = $service;

	}

	public function compose(View $view)
	{
		if (Auth()->user()){
			/** @var Collection $threads */
			$threads = $this->service->findAllThreadsByLoggedUser();
			$numberOfUnreadMessages = array_reduce($threads->all(), function($count, Thread $thread) {
				return $count + $thread->unreadMessages()->count();
			}, 0);
		}


		$view->with(compact('numberOfUnreadMessages'));
	}
}
