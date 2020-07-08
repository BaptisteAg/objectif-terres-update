<?php

namespace App\Http\Controllers\Threads;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\NewMessageNotification;
use App\Services\Ads\AdService;
use App\Services\Documents\DocumentService;
use App\Services\Documents\DocumentServiceInterface;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;
use Carbon\Carbon;
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
	protected $documentService;

	/**
	 * MessagesController constructor.
	 * @param ThreadService $threadService
	 * @param AdService $adService
	 * @param UserService $userService
	 * @param DocumentServiceInterface $documentService
	 */
	public function __construct(ThreadService $threadService, AdService $adService, UserService $userService, DocumentServiceInterface $documentService)
	{
		$this->threadService = $threadService;
		$this->adService = $adService;
		$this->userService = $userService;
		$this->documentService = $documentService;
	}


	/**
	 * @param Thread $thread
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(Thread $thread)
	{


		$messages = $this->threadService->findAllByThread($thread->id);
		$thread = $this->threadService->find($thread->id);
		$this->threadService->setToReadAllUnreadMessagesInThread($thread->id);
		foreach ($messages as $key => $message) {
			$date = Carbon::parse($message->created_at);
			$messages[$key]['day_posted'] = $date->format('d/m/Y');
			$messages[$key]['time_posted'] = $date->format('H:i');
		}

		return response()->json(['thread' => $thread, 'messages' => $messages]);
	}


	/**
	 * @param MessageRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function create(MessageRequest $request)
	{

		$message = $this->threadService->createMessage($request->validated());

		return response()->json((object)$message);
	}


	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function uploadDocuments(Request $request)
	{
		$files = $request->get('files');
		if (!count($files)) {
			return response()->json('Pas de fichiers séléctionnés');
		}
		$documentsIds = [];
		foreach ($files as $document) {
			$documentsIds[] = $document['id'];
		}

		$data = [
			'content' => '',
			'thread_id' => $request->get('thread_id'),
			'sender_user_id' => auth()->id(),
			'documents_ids' => $documentsIds
		];
		$this->threadService->createMessage($data);
		return response()->json($files);
	}


}
