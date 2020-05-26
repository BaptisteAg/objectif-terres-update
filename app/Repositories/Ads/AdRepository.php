<?php namespace App\Repositories\Ads;

use App\Models\Ad;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
	 * Find all ads and projects by user id
	 * @param  $idUser
	 * @return Collection
	 */
	public function allByIdUser($idUser): Collection
	{
		/** @var Collection $model */
		$models = $this->entity
			->where(["user_pp_id" => $idUser])
			->whereNull('project_id')
			->with($this->getEagerLoading())
			->get();
		return $models;
	}

	/**
	 * Find all ads by user id
	 * @param  $idUser
	 * @return Collection
	 */
	public function allAdsByIdUser($idUser): Collection
	{
		/** @var Collection $model */
		$models = $this->entity
			->where(["user_pp_id" => $idUser])
			->whereNull('project_id')
			->with([
				'attributionAd',
				'attributionAd.adStatus',
				'landSeekAd',
				'landOfferAd',
				'jobOfferAd',
				'jobSeekAd',
				'cities',
				'cities.department',
				'cities.department.region',
				'departments',
				'departments.region',
				'regions',
				'documents'
			])
			->get();
		return $models;
	}


	/**
	 * @param array $territoriesCode
	 * @return Collection
	 */
	public function allAdsInTerritories(array $territoriesCode): Collection
	{
		/** @var Collection $models */
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
	 * Find all ads (simple ads or projects) in user (supervisor or advisor) territories
	 * @param array $territoriesCode
	 * @param bool $toPaginate
	 * @return LengthAwarePaginator|Builder[]|Collection
	 */
	public function allInTerritories(array $territoriesCode, bool $toPaginate)
	{
		/** @var Collection $model */
		$models = $this->entity
			->where(function (Builder $query) {
				$query->whereNotNull('project_id');
				$query->whereHas('attributionAd', function (Builder $query) {
					if (auth()->user()->role == 2) {
						$query->where('user_advisor_id', '=', auth()->user()->id);
					} else if (auth()->user()->role >= 3) {
						$query->where('user_supervisor_id', '=', auth()->user()->id);
					}
				});
			})
			->orWhere(function (Builder $query) use ($territoriesCode) {
				$query->whereHas('departments', function (Builder $query) use ($territoriesCode) {
					$query->whereIn('code', $territoriesCode);
				});
				$query->orWhereHas('cities', function (Builder $query) use ($territoriesCode) {
					$query->whereIn('department_code', $territoriesCode);
				});
			});
		$models
			/**TODO find a way to group results first with projects and then ads. Each group has to be order by attribution_ads.created_at **/
			->leftJoin('projects as p', 'p.id', '=', 'ads.project_id')
			->orderByDesc('p.created_at')
			->join('attribution_ads as a', 'a.ad_id', '=', 'ads.id')
			->orderByDesc('a.created_at')
			->with($this->getEagerLoadingForDashboards());
		if ($toPaginate) {
			$ads = $models->paginate(15);
		} else {
			$ads = $models->get();
		}
		return $ads;
	}

	/**
	 * Find all  projects in user (supervisor or advisor) territories
	 * @param array $territoriesCode
	 * @param bool $toPaginate
	 * @return LengthAwarePaginator|Builder[]|Collection
	 */
	public function allProjectsInTerritories(array $territoriesCode, bool $toPaginate)
	{
		/** @var Collection $model */
		$models = $this->entity
			->where(function (Builder $query) {
				$query->whereHas('attributionAd', function (Builder $query) {
					if (auth()->user()->role == 2) {
						$query->where('user_advisor_id', '=', auth()->user()->id);
					} else if (auth()->user()->role >= 3) {
						$query->where('user_supervisor_id', '=', auth()->user()->id);
					}
				});
				$query->whereNotNull('project_id');
			})
			->orWhere(function (Builder $query) use ($territoriesCode) {
				$query->whereHas('departments', function (Builder $query) use ($territoriesCode) {
					$query->whereIn('code', $territoriesCode);
				});
				$query->orWhereHas('cities', function (Builder $query) use ($territoriesCode) {
					$query->whereIn('department_code', $territoriesCode);
				});
				$query->whereNotNull('project_id');
			});

		$models
			->join('attribution_ads as a', 'a.ad_id', '=', 'ads.id')
			->orderByDesc('a.created_at')
			->with($this->getEagerLoadingForDashboards());
		if ($toPaginate) {
			$ads = $models->paginate(15);
		} else {
			$ads = $models->get();
		}
		return $ads;
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
	 * Get all ads (projects and ads) related to a supervisor or an advisor submitted between dates
	 * @param array $territoryCodes
	 * @param array|null $dates
	 * @return Builder[]|Collection
	 */
	public function findAllByUserTerritoriesAndDates(array $territoryCodes, array $dates)
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
				$query->whereHas('project', function (Builder $subQuery) use ($dates) {
					$subQuery->whereBetween('created_at', [$dates[0], $dates[1] . " 23:59:59"]);
				});
				$query->orWhere(function (Builder $subQuery) use ($dates) {
					$subQuery->whereNull('project_id');
					$subQuery->whereHas('attributionAd', function (Builder $q) use ($dates) {
						$q->whereBetween('created_at', [$dates[0], $dates[1] . " 23:59:59"]);
					});
				});
			});
		$ads = $queryAds->with($this->getEagerLoadingForDashboards())->get();

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
			'userPp',
			'adNotes',
			'adNotes.user',
			'documents',
			'documents.user',
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
			'landOfferAd.building',
			'landOfferAd.building.description',
			'landOfferAd.building.surface',
			'landOfferAd.building.offerGenres',
			'landOfferAd.house',
			'landOfferAd.house.description',
			'landOfferAd.house.surface',
			'landOfferAd.house.offerGenres',

			'jobOfferAd',
			'jobOfferAd.educationLevels',
			'jobOfferAd.jobOfferTypes',
			'jobSeekAd',
			'project',
			'project.projectStatus',
			'project.supportState',
			'project.supportStage',

			'attributionAd',
			'attributionAd.userAdvisor',
			'attributionAd.adStatus',


		];
	}

	private function getEagerLoadingForDashboards()
	{
		return [
			'project',
			'project.supportStage',
			'project.supportState',
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
		];
	}
}
