<?php

namespace App\Http\Controllers\Threads;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Models\SupportStage;
use App\Models\Thread;
use App\Services\Ads\AdService;
use App\Services\Advisors\AdvisorsService;
use App\Services\Documents\DocumentServiceInterface;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
	/**
	 * @var UserService
	 */
	protected $userService;
	/**
	 * @var DocumentServiceInterface
	 */
	protected $documentService;

	/**
	 * @var AdvisorsService
	 */
	protected $advisorService;

	/**
	 * MessagesController constructor.
	 * @param ThreadService $threadService
	 * @param AdService $adService
	 * @param UserService $userService
	 * @param DocumentServiceInterface $documentService
	 * @param AdvisorsService $advisorsService
	 */
	public function __construct(ThreadService $threadService, AdService $adService, UserService $userService, DocumentServiceInterface $documentService, AdvisorsService $advisorsService)
	{
		$this->threadService = $threadService;
		$this->adService = $adService;
		$this->userService = $userService;
		$this->documentService = $documentService;
		$this->advisorService = $advisorsService;
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

		//if first message send for advisors/supervisor send to user support request -> update support stage
		if (isset($message->thread->ad->project) && auth()->user()->role >= 2) {
			if ($this->threadService->findMessagesByThreadAndUserId($message->thread->id, auth()->id())->count() === 1) {
				$this->advisorService->updateSupport(['ad_id' => $message->thread->ad->id, 'support_stage' => SupportStage::FIRST_RECEPTION_ID]);
			};
		}
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
