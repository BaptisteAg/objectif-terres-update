<?php namespace App\Repositories\Ads;

use App\Models\Ad;
use Carbon\Carbon;
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
	 * @return Collection
	 */
	public function allByIdUser($idUser): Collection
	{
		/** @var Collection $model */
		$models = $this->entity
			->where(["user_pp_id" => $idUser])
			->with($this->getEagerLoading())
			->get();
		return $models;
	}


	/**
	 * @param array $territoriesCode
	 * @return Collection
	 */
	public function allAdsInTerritories(array $territoriesCode): Collection
	{
		/** @var Collection $model */
		$models = $this->entity
			->whereNull('project_id')
			->where(function (Builder $query) use ($territoriesCode) {
				$query->filterAdsTerritoryLocations($territoriesCode);
			})
			->with([
				'attributionAd',
				'attributionAd.adStatus',
				'landSeekAd',
				'landOfferAd',
				'jobOfferAd',
				'jobSeekAd'
			])
			->get();
		return $models;
	}

	/**
	 * @param array $territoriesCode
	 * @return Collection
	 */
	public function allInTerritoriesGroupByUserPp(array $territoriesCode): Collection
	{
		/** @var Collection $model */
		$models = $this->entity
			->where(function (Builder $query) {
				$query->whereNotNull('project_id');
				$query->whereHas('attributionAd', function (Builder $query) {
					$query->where('user_supervisor_id', '=', auth()->user()->id);
				});
			})
			->orWhere(function (Builder $query) use($territoriesCode) {
				$query->whereHas('departments', function (Builder $query) use ($territoriesCode) {
					$query->whereIn('code', $territoriesCode);
				});
				$query->orWhereHas('cities', function (Builder $query) use ($territoriesCode) {
					$query->whereIn('department_code', $territoriesCode);
				});
			})
			->get()
			->groupBy('user_pp_id');
		return $models;
	}

	/**
	 * @param array $territoriesCode
	 * @param int $adStatusId
	 * @return Collection
	 */
	public function allInTerritoriesByAdStatus(array $territoriesCode, int $adStatusId): Collection
	{
		/** @var Collection $models */
		$models = $this->entity
			->whereNull('project_id')
			->where(function (Builder $query) use ($territoriesCode) {
				$query->filterAdsterritoryLocations($territoriesCode);
			})
			->where(function (Builder $query) use ($adStatusId) {
				$query->whereHas('attributionAd', function (Builder $subQuery) use ($adStatusId) {
					$subQuery->where('ad_status_id', '=', $adStatusId);
				});
			})
			->get();
		return $models;
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
	 * @param int $role
	 * @param array $territoryCodes
	 * @param array|null $dates
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function findAllByUserTerritoriesAndDates(array $territoryCodes, array $dates = null)
	{
		$queryAds = Ad::where(function (Builder $builder) use ($territoryCodes) {
			$builder->whereNotNull('project_id');
			$builder->whereHas('attributionAd', function (Builder $query) {
				if (auth()->user()->role == 2) {
					$query->where('user_advisor_id', '=', auth()->user()->id);
				} else if (auth()->user()->role >= 3) {
					$query->where('user_supervisor_id', '=', auth()->user()->id);
				}
			});
			$builder->orWhereHas('departments', function (Builder $query) use ($territoryCodes) {
				$query->whereIn('code', $territoryCodes);
			});
			$builder->orWhereHas('cities', function (Builder $query) use ($territoryCodes) {
				$query->whereIn('department_code', $territoryCodes);
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
			});
			$queryAds->join('attribution_ads as a', 'a.ad_id', '=', 'ads.id')
			->orderByDesc('a.created_at')
			->with([
				'project',
				'project.projectStatus',
				'userPp',
				'cities',
				'cities.department',
				'cities.department.region',
				'departments',
				'departments.region',
				'regions',
				'attributionAd',
				'attributionAd.adStatus',
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

	/**
	 * @param int $numberOfDays
	 * @return Collection
	 */
	public function findAllPublishedSinceDays(int $numberOfDays): Collection
	{
		return $this->entity
			->whereHas('attributionAd', function (Builder $query) use ($numberOfDays) {
				$query->whereDate('published_on', '=', Carbon::now()->subDays($numberOfDays));
			})
			->with('documents')
			->get();
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
			'jobSeekAd',
			'project',
			'project.projectStatus',
			'attributionAd',
			'attributionAd.adStatus',

		];
	}
}
