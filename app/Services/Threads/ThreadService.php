<?php namespace App\Services\Threads;

use App\Models\Message;
use App\Models\ReadMessage;
use App\Models\Thread;
use App\Models\ThreadUser;
use App\Repositories\Ads\AdRepository;
use App\Repositories\Threads\MessagesRepository;
use App\Repositories\Threads\ThreadsRepository;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Class ThreadService
 * @package App\Services\Threads
 */
class ThreadService
{

	/**
	 * @var ThreadsRepository
	 */
	protected $repository;
	/**
	 * @var AdRepository
	 */
	protected $adRepository;
	/**
	 * @var MessagesRepository
	 */
	protected $messagesRepository;


	/**
	 * ThreadService constructor.
	 * @param ThreadsRepository $repository
	 * @param AdRepository $adRepository
	 * @param MessagesRepository $messagesRepository
	 */
	public function __construct(
		ThreadsRepository $repository,
		AdRepository $adRepository,
		MessagesRepository $messagesRepository
	)
	{
		$this->repository = $repository;
		$this->adRepository = $adRepository;
		$this->messagesRepository = $messagesRepository;
	}


	/**
	 * @return Thread[]
	 */
	public function findAllThreadsByLoggedUser()
	{
		$threads = $this->repository->findAllThreadsByLoggedUser();
		return $threads;

	}

	public function findThreadsByAd(int $adId)
	{
		/** @var Thread $thread */
		$threads = $this->repository->findThreadsByAdId($adId);
		return $threads;

	}


	public function findThreadAlreadyExist(int $adId)
	{
		/** @var Thread $thread */
		$threads = $this->repository->findThreadByLoggedUserAndAdId($adId);
		return $threads;

	}

	/**
	 * @param int $threadId
	 * @return mixed
	 */
	public function findAllByThread(int $threadId)
	{
		$allMessagesInThread = $this->messagesRepository->findAllByThread($threadId);

		foreach ($allMessagesInThread as $message) {
			$date = Carbon::parse($message->created_at)->format('m/d/Y');

		}

		return $allMessagesInThread;

	}

	/**
	 * @param int $threadId
	 * @return mixed
	 */
	public function setToReadAllUnreadMessagesInThread(int $threadId)
	{

		$allUnreadMessagesInThread = $this->messagesRepository->findAllUnreadMessagesByThread($threadId);
		foreach ($allUnreadMessagesInThread as $unreadMessage) {

			$unreadMessage = ReadMessage::where([
				["message_id", $unreadMessage->id],
				["user_id", auth()->id()]])
				->firstOrFail();
			$unreadMessage->is_read = 1;
			$unreadMessage->save();
		}
		return $allUnreadMessagesInThread;
	}

	/**
	 * @param $threads
	 * @return mixed
	 */
	public function countAllUnreadMessagesInThreadsByLoggedUser()
	{
		$threads = $this->repository->findAllThreadsByLoggedUser();
		$numberOfUnreadMessages = 0;
		foreach ($threads as $thread) {
			$numberOfUnreadMessages = $numberOfUnreadMessages + $this->messagesRepository->findAllUnreadMessagesByThread($thread->id)->count();
		}

		return $numberOfUnreadMessages;
	}

	/**
	 * @param array $data
	 * @throws \Throwable
	 */
	public function create(array $data)
	{

		$threadData = Arr::only($data, [
			"ad_id",
			"title"
		]);
		$thread = $this->repository->create($threadData);

		$threadParticipants = [];
		if (isset($data['ad_id'])) {
			$threadParticipants = [
				$this->adRepository->find($data["ad_id"])->user_pp_id,
				auth()->id()
			];
		} else {
			$threadParticipants = [
				auth()->id()
			];
			foreach ($data['receivers_user_message'] as $receiverUserMessage) {
				array_push($threadParticipants, (int)$receiverUserMessage);
			}
		}

		foreach ($threadParticipants as $user_id) {
			$threadUser = new ThreadUser([
				"user_id" => $user_id,
				"thread_id" => $thread->id
			]);
			$threadUser->save();
		}

		if (isset($data['content'])) {
			$messageData = Arr::only($data, ["content"]);
			$messageData["sender_user_id"] = auth()->id();
			$messageData["thread_id"] = $thread->id;

			$message = $this->messagesRepository->create($messageData);
			foreach ($threadParticipants as $user_id) {
				if ($user_id !== auth()->id()) {
					$threadUser = new ReadMessage([
						"message_id" => $message->id,
						"user_id" => $user_id,
					]);
					$threadUser->save();
				}
			}
		}

	}

	/**
	 * @param array $data
	 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 * @throws \Throwable
	 */
	public function createMessage(array $data)
	{
		$test = $this->messagesRepository->create($data);

		$message = $this->messagesRepository->find($test->id);
		foreach ($message->thread->users as $user) {
			if ($user->id !== auth()->id()) {
				$threadUser = new ReadMessage([
					"message_id" => $message->id,
					"user_id" => $user->id,
				]);
				$threadUser->save();
			}
		}
		return $message;
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function findThreadsByUnreadMessage()
	{
		return $this->repository->findThreadsByUnreadMessages();
	}

	/**
	 * @param int $adId
	 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function findThreadsByUnreadMessageAndAdId(int $adId)
	{
		return $this->repository->findThreadsByUnreadMessagesAndAdId($adId);
	}
}