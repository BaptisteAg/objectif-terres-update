<?php namespace App\Repositories\AdMessages;

use App\Htttp\Repositories\AdMessagesRepositoryInterface;
use App\Models\AdMessage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

/**
 * Class ResearchRepository
 * @package App\Repositories\Researches
 * @property AdMessage $entity
 */
class AdMessagesRepository extends AbstractRepository implements AdMessagesRepositoryInterface
{

	public function entity()
	{
		return AdMessage::class;
	}

	public function all($paginate = null)
	{
		return $this->entity
			->orderByDesc('created_at')
			->get();
	}

	/**
	 * @param $id
	 * @return AdMessage
	 */
	public function find($id)
	{
		$model = $this->entity
			->where(["id" => $id])
			->firstOrFail();

		if (!$model) {
			throw (new ModelNotFoundException)->setModel(
				get_class($this->entity->getModel()),
				$id
			);
		}

		return $model;
	}

	/**
	 * Creates message.
	 *
	 * @param int
	 * @param array
	 * @throws \Throwable
	 * @return AdMessage
	 */
	public function create(array $data): AdMessage
	{
		$adMessage = new AdMessage();
		$adMessage->fill($data);
		$adMessage->sf_sender_id = 999;
		$adMessage->save();

		return $adMessage;
	}


}
