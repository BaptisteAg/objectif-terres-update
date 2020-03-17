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

	/**
	 * @param null $paginate
	 * @return Research[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
	 */
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
	 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function findAllResearchesWithAlertActive()
	{
		$model = $this->entity
			->where(["has_alert" => "1"])
			->get();
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
		$research->ad_type = $data['ad_category'] . $data['ad_type'];
		$research->user_id = auth()->user()->id;
		$research->save();

		if (isset ($data['cities_location_researches_ids'])) {
			if (isset ($data['radius_research'])) {
				$research->cities()->attach($data['cities_location_researches_ids'], ['radius' => $data['radius_research']]);
			} else {
				$research->cities()->attach($data['cities_location_researches_ids']);
			}
		}
		if (isset ($data['departments_location_researches_ids'])) {
			$research->departments()->attach($data['departments_location_researches_ids']);
		}

		if (isset ($data['regions_location_researches_ids'])) {
			$research->regions()->attach($data['regions_location_researches_ids']);
		}

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
