<?php

namespace App\Http\Controllers\Threads;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use App\Models\User;
use App\Services\Ads\AdService;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
	/**
	 * @var ThreadService
	 */
	protected $threadService;
	protected $adService;
	protected $userService;

	public function __construct(ThreadService $threadService, AdService $adService, UserService $userService)
	{
		$this->threadService = $threadService;
		$this->adService = $adService;
		$this->userService = $userService;
	}


	public function show(Thread $thread)
	{
		$loggedUserIsParticipant = $thread->users->first(function (User $user) {
			return auth()->id() === $user->id;
		});

		if(!$loggedUserIsParticipant) {
			abort(404);
		}

		$messages = $this->threadService->findAllByThread($thread->id);

		return response()->json($messages);
	}


}
