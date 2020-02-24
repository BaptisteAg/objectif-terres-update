<?php namespace App\Services\Threads;

use App\Models\Message;
use App\Models\Thread;
use App\Models\ThreadUser;
use App\Repositories\Ads\AdRepository;
use App\Repositories\Threads\MessagesRepository;
use App\Repositories\Threads\ThreadsRepository;
use Carbon\Carbon;
use Illuminate\Support\Arr;

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
	 * @param int $userId
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
	public function setToReadAllMessagesInThread(int $threadId)
	{
		$allMessagesInThread = $this->messagesRepository->findAllByThread($threadId);

		$idsToUpdate = [];
		/** @var Message $message */
		foreach ($allMessagesInThread as $message) {
			if ($message->is_read === 0 && auth()->id() !== $message->sender_user_id) {
				$idsToUpdate[] = $message->id;
			}
		}
		$this->messagesRepository->updateMany($idsToUpdate, ["is_read" => 1]);
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

			foreach($data['receivers_user_message'] as $receiverUserMessage){
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

		$messageData = Arr::only($data, ["content"]);
		$messageData["sender_user_id"] = auth()->id();
		$messageData["thread_id"] = $thread->id;

		$this->messagesRepository->create($messageData);
	}

	/**
	 * @param array $data
	 * @return Message
	 * @throws \Throwable
	 */
	public function createMessage(array $data)
	{
		return $this->messagesRepository->create($data);
	}

}