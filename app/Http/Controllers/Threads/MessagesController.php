<?php

namespace App\Http\Controllers\Threads;

use App\Exceptions\SpamContentException;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\SupportStage;
use App\Models\Thread;
use App\Services\Ads\AdService;
use App\Services\Advisors\AdvisorsService;
use App\Services\Documents\DocumentServiceInterface;
use App\Services\RecaptchaService;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

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
	 * @var RecaptchaService
	 */
	protected $recaptchaService;

	/**
	 * MessagesController constructor.
	 * @param ThreadService $threadService
	 * @param AdService $adService
	 * @param UserService $userService
	 * @param DocumentServiceInterface $documentService
	 * @param AdvisorsService $advisorsService
	 * @param RecaptchaService $recaptchaService
	 */
	public function __construct(ThreadService $threadService, AdService $adService, UserService $userService, DocumentServiceInterface $documentService, AdvisorsService $advisorsService, RecaptchaService $recaptchaService)
	{
		$this->threadService = $threadService;
		$this->adService = $adService;
		$this->userService = $userService;
		$this->documentService = $documentService;
		$this->advisorService = $advisorsService;
		$this->recaptchaService = $recaptchaService;
	}


	/**
	 * @param Thread $thread
	 * @return JsonResponse
	 */
	public function show(int $threadId)
	{
        $thread = $this->threadService->find($threadId);
		$messages = $this->threadService->findAllByThread($thread->id);

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
	 * @return JsonResponse
	 * @throws Throwable
	 */
	public function create(MessageRequest $request)
	{
		try {
			// Get reCAPTCHA score (just for logging, no blocking)
			$recaptchaScore = null;
			if (auth()->user()->role < 1) {
				$recaptchaResult = $this->recaptchaService->verify($request->input('recaptcha_token'));
				$recaptchaScore = $recaptchaResult['score'] ?? null;
			}

			$data = $request->validated();
			$data['recaptcha_score'] = $recaptchaScore;

			$message = $this->threadService->createMessage($data);

			//if first message send for advisors/supervisor send to user support request -> update support stage
			if (isset($message->thread->ad->project) && auth()->user()->role >= 2) {
				if ($this->threadService->findMessagesByThreadAndUserId($message->thread->id, auth()->id())->count() === 1) {
					$this->advisorService->updateSupport(['ad_id' => $message->thread->ad->id, 'support_stage' => SupportStage::FIRST_RECEPTION_ID]);
				}
			}
			return response()->json((object)$message);
		} catch (SpamContentException $e) {
			return response()->json([
				'error' => 'spam_detected',
				'message' => $e->getMessage(),
			], 422);
		}
	}


	/**
	 * @param Request $request
	 * @return JsonResponse
	 * @throws Throwable
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

    public function delete($messageId) {
        $message = Message::find($messageId);

        if(!$message || $message->sender_user_id !== auth()->id()) {
            return response("Vous n'êtes pas autorisé à cette action", 403);
        }

        $message->delete();

        return back();
    }
}
