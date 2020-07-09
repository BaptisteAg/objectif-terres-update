<?php namespace App\Services\Threads;

use App\Models\Message;
use App\Models\ReadMessage;
use App\Models\SupportStage;
use App\Models\Thread;
use App\Models\ThreadUser;
use App\Models\User;
use App\Notifications\NewMessage;
use App\Notifications\NewMessageNotification;
use App\Repositories\Ads\AdRepository;
use App\Repositories\Threads\MessagesRepository;
use App\Repositories\Threads\ThreadsRepository;
use App\Services\Advisors\AdvisorsService;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;

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
	 * @param int $threadId
	 * @return Thread
	 */
	public function find(int $threadId)
	{
		return $this->repository->find($threadId);
	}


	/**
	 * @return Thread[]
	 */
	public function findAllThreadsByLoggedUser()
	{
		$threads = $this->repository->findAllThreadsByLoggedUser();
		return $threads;

	}

	/**
	 * @param int $adId
	 * @return Thread
	 */
	public function findThreadsByAd(int $adId)
	{
		/** @var Thread $thread */
		$threads = $this->repository->findThreadsByAdId($adId);
		return $threads;

	}


	/**
	 * @param int $userId
	 * @param int $adId
	 * @return Collection
	 */
	public function findThreadAlreadyExist(int $userId, int $adId)
	{
		/** @var Collection $thread */
		$thread = $this->repository->findThreadByUserIdAndAdId($userId, $adId);
		return $thread;

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
	 * @return int
	 */
	public function countAllUnreadMessagesInThreadsByLoggedUser(): int
	{
		$unreadMessage = $this->repository->findAllThreadsWithUnreadMessagesForUser(auth()->id());
		return $unreadMessage->count();
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
			//in case of new automatic message send after 10 days since the publication of ad
			if (isset($data['supervisor_id'])) {
				$threadParticipants = [
					$this->adRepository->find($data["ad_id"])->user_pp_id,
					$data['supervisor_id']
				];
			} elseif (isset($data['advisor_id'])) {
				//in case of new thread created in advisor's support request dashboard
				$threadParticipants = [
					$this->adRepository->find($data["ad_id"])->user_pp_id,
					$data['advisor_id']
				];
			} else {
				//in case of new message send from the ad view
				$threadParticipants = [
					$this->adRepository->find($data["ad_id"])->user_pp_id,
					auth()->id()
				];
			}
			//in case of new message send from the user profil view, message is no related to a specific ad
		} elseif (isset($data['user_pp_id'])) {
			$threadParticipants = [
				$data['user_pp_id'],
				auth()->id()
			];
			//in case of new message from a member of TdL to one or multiple members of Tdl
		} else {
			$threadParticipants = [
				auth()->id()
			];
			if (isset ($data['receivers_user_message'])) {
				foreach ($data['receivers_user_message'] as $receiverUserMessage) {
					array_push($threadParticipants, (int)$receiverUserMessage);
				}
			} else {
				abort(redirect()->back()->with('warning', 'Aucun interlocuteur séléctionné'));
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
			$messageData["sender_user_id"] = (isset($data['supervisor_id'])) ? $data['supervisor_id'] : auth()->id();
			$messageData["thread_id"] = $thread->id;
			$message = $this->messagesRepository->create($messageData);
			foreach ($threadParticipants as $user_id) {
				if (isset($data['supervisor_id'])) {
					if ($user_id !== $data['supervisor_id']) {
						$threadUser = new ReadMessage([
							"message_id" => $message->id,
							"user_id" => $user_id,
						]);
						$user = User::find($user_id);
						$supervisor = User::find($data['supervisor_id']);
						$user->notify(new NewMessageNotification([
							'sender_name' => $supervisor->name,
							'sender_first_name' => $supervisor->first_name,
							'message_content' => $message->content
						]));
					}
				} else {
					if ($user_id !== auth()->id()) {
						$threadUser = new ReadMessage([
							"message_id" => $message->id,
							"user_id" => $user_id,
						]);
						$user = User::find($user_id);
						$user->notify(new NewMessageNotification([
							'sender_name' => auth()->user()->name,
							'sender_first_name' => auth()->user()->first_name,
							'message_content' => $message->content
						]));
					}
				}
				$threadUser->save();
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
		$messageCreated = $this->messagesRepository->create($data);

		$message = $this->messagesRepository->find($messageCreated->id);

//		if (isset($message->thread->ad->project) && auth()->user()->role >= 2) {
//			if ($this->findMessagesByThreadAndUserId($message->thread->id, auth()->id())->count() === 1) {
//				$this->advisorService->updateSupport(['ad_id' => $message->thread->ad->id, 'support_stage' => SupportStage::FIRST_RECEPTION_ID]);
//			};
//		}

		foreach ($message->thread->users as $user) {
			$user = User::find($user->id);

			if ($user->id !== auth()->id()) {
				if (isset($data['supervisor_id'])) {
					//in case of an automatic message from the supervisor
					$supervisor = User::find($data['supervisor_id']);
					if ($user->id !== $data['supervisor_id']) {
						$threadUser = new ReadMessage([
							"message_id" => $message->id,
							"user_id" => $user->id,
						]);
						$threadUser->save();
						$user->notify(new NewMessageNotification([
							'sender_name' => $supervisor->name,
							'sender_first_name' => $supervisor->first_name,
							'message_content' => $message->content
						]));
					}
				} else {
					$threadUser = new ReadMessage([
						"message_id" => $message->id,
						"user_id" => $user->id,
					]);
					$threadUser->save();
					$user->notify(new NewMessageNotification([
						'sender_name' => auth()->user()->name,
						'sender_first_name' => auth()->user()->first_name,
						'message_content' => $message->content
					]));
				}
			}
		}

		return $message;
	}


	/**
	 * @return Collection
	 */
	public function findThreadsWithUnreadMessages(int $userId)
	{
		return $this->repository->findAllThreadsWithUnreadMessagesForUser($userId);
	}

	/**
	 * @param int $adId
	 * @return Collection
	 */
	public function findThreadsByUnreadMessageAndAdId(int $adId)
	{
		return $this->repository->findThreadsByUnreadMessagesAndAdId($adId);
	}

	public function findMessagesByThreadAndUserId(int $threadId, int $userId): Collection
	{
		return $this->messagesRepository->findAllMessagesByThreadAndUser($threadId, $userId);
	}
}