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
		$threads = $this->messageService->findAllThreads(auth()->user()->id);
		$interlocutors = [];
		foreach ($threads as $thread){
			$interlocutors[$thread->thread_id] = $this->messageService->findInterlocutorsByThread($thread->thread_id,auth()->user()->id );
		}

		foreach($interlocutors as $threadId=>$interlocutor){
			foreach ($interlocutor as $key=>$idUser)
			$interlocutors[$threadId][$key] = $this->userService->find($idUser);
		};

		return view('pages.messages.index', compact('interlocutors'));

	}
}
