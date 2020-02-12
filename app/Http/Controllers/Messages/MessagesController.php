<?php

namespace App\Http\Controllers\Messages;

use App\Http\Controllers\Controller;
use App\Services\Ads\AdService;
use App\Services\Messages\MessagesService;
use App\Services\Users\UserService;

class MessagesController extends Controller
{
	/**
	 * @var MessagesService
	 */
	protected $messageService;
	protected $adService;
	protected $userService;

	public function __construct(MessagesService $messageService, AdService $adService, UserService $userService)
	{
		$this->messageService = $messageService;
		$this->adService = $adService;
		$this->userService = $userService;
	}

	/**
	 *
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$threads = $this->messageService->findAllThreadsByUserId(auth()->user()->id);

		$messagesByThread = [];
		foreach ($threads as $thread){
			$messagesByThread[$thread->thread_id] = $this->messageService->findAllByThread($thread->thread_id);
		}

		return view('pages.messages.index', compact('messagesByThread'));

	}


}
