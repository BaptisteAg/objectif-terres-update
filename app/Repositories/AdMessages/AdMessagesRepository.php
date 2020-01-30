<?php namespace App\Repositories\AdMessages;

use App\Models\AdMessage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

/**
 * Class AdMessageRepository
 * @package App\Repositories\AdMessage
 * @property AdMessage $entity
 */
class AdMessagesRepository extends AbstractRepository implements AdMessagesRepositoryInterface
{

	/**
	 * @return string
	 */
	public function entity()
	{
		return AdMessage::class;
	}

	/**
	 * @param null $paginate
	 * @return AdMessage[]|\Illuminate\Support\Collection|mixed
	 */
	public function all($paginate = null)
	{
		return $this->entity
			->orderByDesc('created_at')
			->get();
	}


	/**
	 * @param $id
	 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
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
