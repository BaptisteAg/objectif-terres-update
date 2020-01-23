<?php namespace App\Repositories\Researches;

use App\Htttp\Repositories\ResearchRepositoryInterface;
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
	 * @return Research
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
	 * Creates a research.
	 *
	 * @param int
	 * @param array
	 * @throws \Throwable
	 */
	public function create(array $data): Research
	{
		$research = new Research();
		$researchData = $data;
		$research->fill($researchData);
		$research->sf_id = 999;
		$research->save();

		$research->regions()->attach($data['regions']);

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
