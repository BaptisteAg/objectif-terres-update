<?php

namespace App\Http\Controllers\Threads;

use App\Http\Controllers\Controller;
use App\Services\Ads\AdService;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;

class MessagesController extends Controller
{
	/**
	 * @var ThreadService
	 */
	protected $messageService;
	protected $adService;
	protected $userService;

	public function __construct(ThreadService $messageService, AdService $adService, UserService $userService)
	{
		$this->messageService = $messageService;
		$this->adService = $adService;
		$this->userService = $userService;
	}


	public function index(\Request $request)
	{
		$messages = $this->messageService->findAllByThread($request->get('thread_id'));

		return response()->json($messages);
	}


}
