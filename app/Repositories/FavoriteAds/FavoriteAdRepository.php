<?php namespace App\Repositories\FavoriteAds;

use App\Models\FavoriteAd;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

/**
 * Class FavoriteAdRepository
 * @package App\Repositories\FavoriteAds
 * @property FavoriteAd $entity
 */
class FavoriteAdRepository extends AbstractRepository implements FavoriteAdRepositoryInterface
{

	public function entity()
	{
		return FavoriteAd::class;
	}

	public function all($paginate = null)
	{
		return $this->entity
			->with($this->getEagerLoading())
			->orderByDesc('created_at')
			->get();
	}

	/**
	 * Find a Favorite ad by its id.
	 * @param $id
	 * @return FavoriteAd
	 */
	public function find($id)
	{

		$model = $this->entity
			->where(["id" => $id])
			->with('ad')
			->first();


		if (!$model) {

			throw (new ModelNotFoundException)->setModel(
				get_class($this->entity->getModel()),
				$id
			);
		}
		return $model;
	}

	/**
	 * Find a Favorite ad by the user id.
	 * @param $id
	 * @return FavoriteAd
	 */
	public function findAllByUserId(int $id)
	{
		$model = $this->entity
			->where("user_id" , $id)
			->get();

		if (!$model) {
			throw (new ModelNotFoundException)->setModel(
				get_class($this->entity->getModel()),
				$id
			);
		}
		return $model;
	}

	/**
	 * Gets favorite ad by the sf_id AND the ad_id
	 * @param array
	 * @return FavoriteAd
	 */
	public function findByUserAndAdId(array $data)
	{

		$favoriteAd = $this->entity
			->where("ad_id", $data['ad_id'])
			->where("user_id", $data['user_id'])
			->first();

		return $favoriteAd;
	}

	/**
	 * Creates an favorite ad.
	 *
	 * @param array
	 * @return FavoriteAd
	 * @throws \Throwable
	 */
	public function create(array $data): FavoriteAd
	{
		$favoriteAd = new FavoriteAd();
		$favoriteAd->fill($data);
		$favoriteAd->save();


		return $favoriteAd;
	}

	/**
	 * Delete an favorite ad.
	 *
	 * @param FavoriteAd $favoriteAd
	 * @return bool|null
	 * @throws \Exception
	 */
	public function destroy(FavoriteAd $favoriteAd)
	{
		return $favoriteAd->delete();

	}



}
