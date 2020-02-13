<?php

namespace App\Http\Controllers\Threads;

use App\Http\Controllers\Controller;
use App\Http\Requests\ThreadRequest;
use App\Services\Threads\ThreadService;
use Illuminate\Http\Request;

class ThreadsController extends Controller
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
		$threads = $this->service->findAllThreadsByLoggedUser();

		$threads = json_encode($threads);

		return view('pages.messages.index', compact('threads'));

	}


	/**
	 * @param int $threadId
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(int $threadId)
	{
		$allMessageInThread = $this->service->findAllByThread($threadId);

		return response()->json([
			$allMessageInThread
		]);

	}
}
