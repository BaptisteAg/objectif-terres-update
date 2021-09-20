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
use Throwable;

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
	 * @param int $adId
	 * @return Thread
	 */
	public function findByAdId(int $adId)
	{
		return $this->repository->findThreadByAdId($adId);
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
	 * @param array $data
	 */
	public function addUserInThread(array $data): void

	{
		$thread = $this->repository->find($data['thread_id']);
		if (isset($thread)) {
			$thread->users()->save(User::find($data['user_id']));
		}
	}

	/**
	 * @param array $data
	 */
	public function addUserInSupportRequestThread(array $data): void

	{
		$thread = $this->repository->find($data['thread_id']);
		if (isset($thread)) {
			foreach ($thread->users as $user) {
				if ($user->id !== $data['user_id'] && $user->id !== $data['user_pp_id']) {
					$thread->users()->detach($user->id);
				}
			}
			$thread->users()->save(User::find($data['user_id']));
		}
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
			} elseif (isset($data['title'])) {
				//in case of new thread created when submitting new support request
				$threadParticipants = [
					$this->adRepository->find($data["ad_id"])->user_pp_id,
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
			$messageData["content"] = $this->convertContentToHTML($messageData["content"]);
			$message = $this->messagesRepository->create($messageData);
			$notificationData = $this->getMessageNotificationAdData($thread);
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
							'message_content' => $message->content,
							'ad_type' => $notificationData['ad_type'],
							'ad_title' => $notificationData['ad_title']
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
							'message_content' => $message->content,
							'ad_type' => $notificationData['ad_type'],
							'ad_title' => $notificationData['ad_title']
						]));
					}
				}
				$threadUser->save();
			}
		}
	}

	/**
	 * @param string $content
	 * @return string
	 */
	public function convertContentToHTML(string $content): string
	{
		$content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $content);
		$content = htmlspecialchars($content);
		$content = strip_tags($content);
//		$match_href = '|((https?://)?([\d\w\.-]+\.[\w\.]{2,6})[^\s\]\[\<\>]*/?)|i';
//		$match_hash = '|\B#([\d\w_]+)|i';
//		$match_plus = '|\B\+([\d\w_]+)|i';
//		$replace_url = '<a href="$1" target="_blank">$3</a>';
//		$replace_tag = '<a href="http://url.com/pluslink/$1" target="_blank">$0</a>';
//		$content = preg_replace($match_href, $replace_url, $content);
//		$content = preg_replace($match_hash, $replace_tag, $content);
//		$content = preg_replace($match_plus, $replace_tag, $content);

		$url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
		$content = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $content);

		return "<p>" . $content . "</p>";
	}


	/**
	 * @param array $data
	 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 * @throws \Throwable
	 */
	public function createMessage(array $data)
	{
		$data['content'] = $this->convertContentToHTML($data['content']);
		$messageCreated = $this->messagesRepository->create($data);

		$message = $this->messagesRepository->find($messageCreated->id);
		$message->thread->update(['updated_at' => Carbon::now()]);
		$notificationData = $this->getMessageNotificationAdData($message->thread);
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
							'message_content' => $message->content,
							'ad_type' => $notificationData['ad_type'],
							'ad_title' => $notificationData['ad_title']
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
						'message_content' => $message->content,
						'ad_type' => $notificationData['ad_type'],
						'ad_title' => $notificationData['ad_title']
					]));
				}
			}
		}

		return $message;
	}


	/**
	 * @param int $adId
	 * @return Thread|null
	 * @throws Throwable
	 */
	public function createSupportRequestThread(int $adId, int $advisorId)
	{
		$threadData = [
			'ad_id' => $adId,
			'advisor_id' => $advisorId,
//			'content' => 'Bonjour. Je suis ' . auth()->user()->first_name . ' ' . auth()->user()->name . ', membre de l\'équipe Terre de Liens. Je vais vous accompagner pour la réalisation de votre projet. Vous pouvez utiliser cette messagerie pour me contacter dès que vous le souhaitez.',
		];
		$this->create($threadData);
		$thread = $this->findSupportRequestThread($adId);
		return $thread;
	}


	/**
	 * @param array $data
	 * @return Thread|null
	 * @throws \Throwable
	 */
	public function createSupportRequestThreadFromResume(array $data)
	{
		$this->create($data);
		$thread = $this->findSupportRequestThread($data['ad_id']);
		return $thread;
	}


	/**
	 * @param int $adId
	 * @return Thread| null
	 * TODO refactor, too similar with a another method
	 */
	public function findSupportRequestThread(int $adId)
	{
		/** @var Thread $thread */
		$thread = $this->repository->findThreadByAdId($adId);
		return $thread;
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

	/**
	 * @param int $threadId
	 * @param int $userId
	 * @return Collection
	 */
	public function findMessagesByThreadAndUserId(int $threadId, int $userId): Collection
	{
		return $this->messagesRepository->findAllMessagesByThreadAndUser($threadId, $userId);
	}

	/**
	 * @param array $data
	 * @return Thread|bool|\Illuminate\Database\Eloquent\Model|object
	 */
	public function findUserInAdThread(array $data)
	{
		return $this->repository->findThreadByUserIdAndAdId($data['user_id'], $data['ad_id'])->first();
	}


	/**
	 * @param Thread $thread
	 * @return null[]
	 */
	public function getMessageNotificationAdData(Thread $thread): array
	{
		$notificationData = [
			'ad_title' => null,
			'ad_type' => null,
		];
		//Handling notification data
		if (!is_null($thread->ad)) {
			$notificationData['ad_title'] = $thread->ad->title;
			if (is_null($thread->ad->project)) {
				$notificationData['ad_type'] = "annonce";
			} else {
				$notificationData['ad_type'] = "projet";
			}
		}

		return $notificationData;
	}


	public function createOrUpdateThread(array $data): void
	{
		$thread = $this->findUserInAdThread(['user_id' => $data['user_id'], 'ad_id' => $data['ad_id']]);
		if (isset($thread)) {
			$this->createMessage(['content' => $data['content'], "thread_id" => $thread->id]);
		} else {
			$this->create($data);
		}
	}
}
