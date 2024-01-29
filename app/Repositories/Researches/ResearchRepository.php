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
            ->orderByDesc('created_at')
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
		$research->ad_type = $data['ad_category'];
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

		if (isset ($data['production_genres'])){
			$research->productionGenres()->attach($data['production_genres']);
		}

		if(isset ($data['bio_certifications'])){
			$research->bioCertifications()->attach($data['bio_certifications']);
		}

		if(isset ($data['offer_genres'])){
			$research->offerGenres()->attach($data['offer_genres']);
		}

		if(isset ($data['jobOfferType'])){
			$research->jobOfferTypes()->attach($data['jobOfferType']);
		}

		return $research;
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
