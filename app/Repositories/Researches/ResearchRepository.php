<?php namespace App\Repositories\Researches;

use App\Models\Ad;
use App\Models\Research;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

/**
 * Class ResearchRepository
 * @package App\Repositories\Researches
 * @property Research $entity
 */
class ResearchRepository extends AbstractRepository implements ResearchRepositoryInterface
{

	public function entity()
	{
		return Research::class;
	}

	public function all($paginate = null)
	{
		return $this->entity
			->with($this->getEagerLoading())
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
			->with($this->getEagerLoading())
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
	 * @param $id
	 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function findAllByUser($id)
	{
		$model = $this->entity
			->where(["user_id" => $id])
			->with($this->getEagerLoading())
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
	 * Creates a research.
	 *
	 * @param array $data
	 * @return Research
	 */
	public function create(array $data): Research
	{
		$research = new Research();
		$researchData = $data;
		$research->fill($researchData);
		$research->user_id = auth()->user()->id;
		$research->save();

		$research->regions()->attach($data['regions']);

		return $research;
	}

	public function findRelatedAds(int $id)
	{
		$research = $this->find($id);
		$regions = $research->regions;
		$adType = $research->ad_type;

		$ads = collect();
		foreach ($regions as $region) {
			$regionAds = $region->ads;
			foreach ($regionAds as $key => $ad) {
				if ($ad->$adType) {
					$ads[$ad->id] = $ad;
				}
			}
		}
		return $ads;
	}


	private function getEagerLoading()
	{
		return [

			'cities',
			'cities.department',
			'cities.department.region',
			'departments',
			'departments.region',
			'regions',
		];
	}
}
