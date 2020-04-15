<?php namespace App\Repositories\Ads;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

/**
 * Class AdRepository
 * @package App\Repositories\Ads
 * @property Ad $entity
 */
class AdRepository extends AbstractRepository implements AdRepositoryInterface
{
	public function entity()
	{
		return Ad::class;
	}

	public function all($paginate = null)
	{
		return $this->entity
			->with($this->getEagerLoading())
			->get();
	}

	/**
	 * @param $id
	 * @return Ad
	 */
	public function find($id)
	{
		/** @var Ad $model */
		$model = $this->entity
			->where(["id" => $id])
			->with($this->getEagerLoading())
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
	 * @param  $idUser
	 * @return Ad[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function allByIdUser($idUser)
	{
		/** @var Ad $model */
		$model = $this->entity
			->where(["user_pp_id" => $idUser])
			->with($this->getEagerLoading())
			->get();

		if (!$model) {
			throw (new ModelNotFoundException)->setModel(
				get_class($this->entity->getModel()),
				$idUser
			);
		}
		return $model;
	}


	/**
	 * @param array $territoriesCode
	 * @return \Illuminate\Support\Collection
	 */
	public function allInTerritories(array $territoriesCode)
	{
		$models = $this->entity
			->whereNull('project_id')
			->where(function (Builder $query) use ($territoriesCode) {
				$query->whereHas('departments', function (Builder $query) use ($territoriesCode) {
					$query->whereIn('code', $territoriesCode);
				});
				$query->orWhereHas('cities', function (Builder $query) use ($territoriesCode) {
					$query->whereIn('department_code', $territoriesCode);
				});
			})
			->get();
		if (!$models) {
			throw (new ModelNotFoundException)->setModel(
				get_class($this->entity->getModel()),
				$territoriesCode
			);
		}
		return $models;
	}

	/**
	 * @param array $territoriesCode
	 * @return Ad[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function allInTerritoriesGroupByUserPp(array $territoriesCode)
	{
		/** @var Ad $model */
		$model = $this->entity
			->select('user_pp_id')
			->whereHas('departments', function (Builder $query) use ($territoriesCode) {
				$query->whereIn('code', $territoriesCode);
			})
			->orWhereHas('cities', function (Builder $query) use ($territoriesCode) {
				$query->whereIn('department_code', $territoriesCode);
			})
			->groupBy('user_pp_id')
			->get();
		if (!$model) {
			throw (new ModelNotFoundException)->setModel(
				get_class($this->entity->getModel()),
				$territoriesCode
			);
		}
		return $model;
	}

	/**
	 * @param array $territoriesCode
	 * @return Ad[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function allInTerritoriesByAdStatus(array $territoriesCode, int $adStatusId)
	{
		/** @var Ad $model */
		$model = $this->entity
			->whereNull('project_id')
			->where(function (Builder $query) use ($territoriesCode) {
				$query->whereHas('departments', function (Builder $subQuery) use ($territoriesCode) {
					$subQuery->whereIn('code', $territoriesCode);
				});
				$query->orWhereHas('cities', function (Builder $subQuery) use ($territoriesCode) {
					$subQuery->whereIn('department_code', $territoriesCode);
				});
			})
			->where(function (Builder $query) use ($adStatusId) {
				$query->whereHas('attributionAd', function (Builder $subQuery) use ($adStatusId) {
					$subQuery->where('ad_status_id', '=', $adStatusId);
				});
			})
			->get();
		if (!$model) {
			throw (new ModelNotFoundException)->setModel(
				get_class($this->entity->getModel()),
				$territoriesCode
			);
		}
		return $model;
	}


	/**
	 * Creates an ad.
	 *
	 * @param int
	 * @param array
	 * @return Ad
	 * @throws \Throwable
	 */
	public function create(array $data): Ad
	{
		$ad = new Ad();

		$ad->fill($data);

		$ad->user_pp_id = auth()->user()->id;
		$ad->is_draft = false;
		$ad->save();

		foreach (["cities", "departments", "regions"] as $locationableType) {
			$locationables = $data["locationable"][$locationableType] ?? [];
			if (count($locationables)) {
				if (isset($data["locationable_radius"])) {
					$ad->$locationableType()->attach($locationables, ["radius" => $data["locationable_radius"]]);
				} else {
					$ad->$locationableType()->attach($locationables);
				}
			}
		}
		if (isset($data["documents_ids"]) && is_array($data["documents_ids"])) {
			foreach ($data["documents_ids"] as $documentId) {
				$ad->documents()->attach($documentId);
			}
		}

		return $ad;
	}

	/**
	 * Delete an  ad.
	 *
	 * @param int
	 * @throws \Exception
	 */
	public function destroy(int $id)
	{

		$ad = $this->find($id);
		$ad->delete();

	}

	/**
	 * Get all ads related to a supervisor : attribution ads or projects located in one of the territories managed by the supervisor
	 * @param array $data
	 * @param array|null $dates
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function findAllBySupervisorTerritoriesAndDates(array $data, array $dates = null)
	{
		$queryAds = Ad::where(function (Builder $builder) use ($data) {
			$builder->whereNotNull('project_id');
			$builder->whereHas('attributionAd', function (Builder $query) {
				$query->where('user_supervisor_id', '=', auth()->user()->id);
			});
			$builder->orWhereHas('departments', function (Builder $query) use ($data) {
				$query->whereIn('code', $data);
			});
			$builder->orWhereHas('cities', function (Builder $query) use ($data) {
				$query->whereIn('department_code', $data);
			});
		})
			->where(function (Builder $query) use ($dates) {
				if (!is_null($dates)) {
					$query->whereHas('project', function (Builder $subQuery) use ($dates) {
						$subQuery->whereBetween('created_at', [$dates[0], $dates[1] . " 23:59:59"]);
					});
					$query->orWhere(function (Builder $subQuery) use ($dates) {
						$subQuery->whereNull('project_id');
						$subQuery->whereHas('attributionAd', function (Builder $q) use ($dates) {
							$q->whereBetween('created_at', [$dates[0], $dates[1] . " 23:59:59"]);
						});
					});
				}
			})
			->with([
				'project',
				'userPp',
				'cities',
				'cities.department',
				'cities.department.region',
				'departments',
				'departments.region',
				'regions',
				'attributionAd',
				'landSeekAd',
				'landOfferAd',
				'jobOfferAd',
				'jobSeekAd'

			]);
		if (is_null($dates)) {
			$ads = $queryAds->paginate(15);
		} else {
			$ads = $queryAds->get();
		}
		return $ads;
	}


	private function getEagerLoading()
	{
		return [
			'documents',
			'cities',
			'cities.department',
			'cities.department.region',
			'departments',
			'departments.region',
			'regions',

			'threads',
			'threads.messages',
			'threads.users',
			'threads.messages.senderUser',

			'landSeekAd',
			'landSeekAd.buildings',
			'landSeekAd.buildings.buildingType',
			'landSeekAd.buildings.requirement',

			'landOfferAd',
			'landOfferAd.productionGenres',
			'landOfferAd.productionGenresPossible',
			'landOfferAd.bioCertifications',
			'landOfferAd.offerGenres',

			'jobOfferAd',
			'jobOfferAd.educationLevels',
			'jobOfferAd.jobOfferTypes',
		];
	}
}
