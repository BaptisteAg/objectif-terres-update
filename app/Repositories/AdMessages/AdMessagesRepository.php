<?php namespace App\Repositories\AdMessages;

use App\Models\Ad;
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
	 * @param int $userId
	 * @param int $adId
	 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function findByUserAndAd($userId, $adId)
	{
		/** @var AdMessage $model */
		$model = $this->entity
			->where(["user_id" => $userId, 'ad_id'=> $adId])
			->first();
		return $model;
	}

	/**
	 * @param $id
	 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function findAllByAd(Ad $ad)
	{
		/** @var AdMessage $model */
		$model = $this->entity
			->where(["ad_id" => $ad->id])
			->get();


		if (!$model) {
			throw (new ModelNotFoundException)->setModel(
				get_class($this->entity->getModel()),
				$ad->id
			);
		}

		return $model;
	}

	/**
	 * Creates message.
	 *
	 * @param int
	 * @param array
	 * @return AdMessage
	 * @throws \Throwable
	 */
	public function create(array $data): AdMessage
	{
		$adMessage = new AdMessage();
		$adMessage->fill($data);
		$adMessage->user_id = auth()->user()->id;
		$adMessage->save();

		return $adMessage;
	}


}
