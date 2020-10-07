<?php

namespace App\Http\Controllers\Threads;

use App\Http\Controllers\Controller;
use App\Http\Requests\ThreadRequest;
use App\Models\ResponseTemplate;
use App\Models\Thread;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;
use Illuminate\Support\Collection;

/**
 * Class ThreadsController
 * @package App\Http\Controllers\Threads
 */
class ThreadsController extends Controller
{
	/**
	 * @var ThreadService
	 */
	protected $service;
	protected $userService;


	/**
	 * ThreadsController constructor.
	 * @param ThreadService $service
	 * @param UserService $userService
	 */
	public function __construct(ThreadService $service, UserService $userService)
	{
		$this->service = $service;
		$this->userService = $userService;

	}

	/**
	 * @param ThreadRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Throwable
	 */
	public function create(ThreadRequest $request)
	{
		$this->service->create($request->validated());
		return redirect()->back()->with('success',
			"Votre message a bien été envoyé. Retrouvez tous vos messages dans la <a href='/mon-espace/messagerie'>messagerie</a>"
		);
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		/** @var Collection $threads */
		$threads = $this->service->findAllThreadsByLoggedUser();
		$threadsWithUnreadMessages = $this->service->findThreadsWithUnreadMessages(auth()->id());
		$users = null;
		$responseTemplates = '';
		if (auth()->user()->role >= 1) {
			$users = $this->userService->findAllExceptPPAndLoggedUser();
			$users = json_encode($this->userService->findAllExceptPPAndLoggedUser());
			$responseTemplates = ResponseTemplate::all();
		}

		return view('pages.messages.index', compact('threads', 'users', 'threadsWithUnreadMessages', 'responseTemplates'));
	}

	public function refreshUnreadMessages()
	{
		/** @var Collection $threads */
		$threads = $this->service->findAllThreadsByLoggedUser();
		$threadsWithUnreadMessages = $this->service->findThreadsWithUnreadMessages(auth()->id());
		return response()->json($threadsWithUnreadMessages);
	}

}
