<?php

namespace App\Http\Controllers\Threads;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Models\Thread;
use App\Models\User;
use App\Services\Ads\AdService;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MessagesController extends Controller
{
	/**
	 * @var ThreadService
	 */
	protected $threadService;
	/**
	 * @var AdService
	 */
	protected $adService;
	protected $userService;

	/**
	 * MessagesController constructor.
	 * @param ThreadService $threadService
	 * @param AdService $adService
	 * @param UserService $userService
	 */
	public function __construct(ThreadService $threadService, AdService $adService, UserService $userService)
	{
		$this->threadService = $threadService;
		$this->adService = $adService;
		$this->userService = $userService;
	}


	/**
	 * @param Thread $thread
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(Thread $thread)
	{
		$loggedUserIsParticipant = $thread->users->first(function (User $user) {
			return auth()->id() === $user->id;
		});

		if(!$loggedUserIsParticipant) {
			abort(404);
		}

		$messages = $this->threadService->findAllByThread($thread->id);
		$this->threadService->setToReadAllMessagesInThread($thread->id);
		return response()->json($messages);
	}


	/**
	 * @param MessageRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function create(MessageRequest $request)
	{
		$message = $this->threadService->createMessage($request->validated());

		return response()->json($message);
	}

}
