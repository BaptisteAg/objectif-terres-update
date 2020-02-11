<?php namespace App\Services\Messages;

use App\Models\Ad;
use App\Repositories\AdMessages\AdMessagesRepository;
use App\Repositories\AdMessages\AdMessagesRepositoryInterface;
use App\Repositories\Messages\MessagesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class MessagesService
 * @package App\Services\Messages
 */
class MessagesService
{

	/**
	 * @var MessagesRepository
	 */
	protected $repository;


	/**
	 * AdMessagesService constructor.
	 * @param MessagesRepository $repository
	 */
	public function __construct(MessagesRepository $repository)
	{
		$this->repository = $repository;
	}


	/**
	 * @param User $id
	 * @return mixed
	 */
	public function findAllThreads(int $id)
	{
		$messages = $this->repository->findAllThreads($id);

		return $messages;

	}

	/**
	 * @param int $threadId
	 * @return mixed
	 */
	public function findAllByThread(int $threadId)
	{
		$messages = $this->repository->findAllByThread($threadId);
		return $messages;

	}

	/**
	 * @param int $threadId
	 * @param int $userId
	 * @return mixed
	 */
	public function findInterlocutorsByThread(int $threadId, int $userId){
		$messages = $this->repository->findAllByThread($threadId);
		$interlocutors= [];
		foreach ($messages as $message){
			if ($message->sender_user_id !== $userId){
				array_push($interlocutors, $message->sender_user_id);
			}else{
				array_push($interlocutors, $message->receiver_user_id);
			}
			array_unique($interlocutors);
		}
		return $interlocutors;

	}

}