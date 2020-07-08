<?php namespace App\Repositories\Ads;

use App\Models\Ad;
use App\Models\AttributionAd;
use App\Models\City;
use App\Models\Department;
use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
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
			->with($this->getFullEagerLoading())
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
			->with($this->getFullEagerLoading())
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
	 * @param $id
	 * @return Ad
	 */
	public function findWithTrashedUser($id)
	{
		/** @var Ad $model */
		$model = $this->entity
			->where(["id" => $id])
			->with($this->getDashboardsEagerLoading())
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
        $ad->user_pp_id = auth()->user()->id;

        $this->save($ad, $data);

		return $ad;
	}

	/**
	 * Updates an ad.
	 *
	 * @param Ad|int $ad
	 * @param array $data
	 * @return Ad
	 * @throws \Throwable
	 */
	public function update($ad, array $data): Ad
	{
	    if(!is_a($ad, Ad::class)) {
	        $ad = $this->find($ad);
        }

        $this->save($ad, $data);

		return $ad;
	}

    private function save(Ad $ad, array $data)
    {
        $ad->fill($data);

        $ad->save();

        foreach (["cities", "departments", "regions"] as $locationableType) {
            $locationables = $data["locationable"][$locationableType] ?? [];

            if (count($locationables)) {
                $extraFields = [];
                if (isset($data["locationable_radius"])) {
                    $extraFields =  ["radius" => $data["locationable_radius"]];
                }

                /** @var MorphToMany $locationableEntityQuery */
                $locationableEntityQuery = $ad->$locationableType();

                $locationableEntityQuery->sync($locationables, $extraFields);
            }
        }
        if (!empty($data["documents_ids"]) && is_array($data["documents_ids"])) {
            $ad->documents()->sync($data["documents_ids"]);
        }
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
	public function allByIdUser($idUser, $conditions = []): Collection
	{
	    $query = $this->entity
            ->where(["user_pp_id" => $idUser])
            ->with($this->getDashboardsEagerLoading())
            ->orderByDesc('id');

	    foreach($conditions as $column => $value) {
	        $query->where($column, $value);
        }

		/** @var Collection $model */
		$models = $query
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
				'documents',
				'userPp' => function ($query) {
					$query->withTrashed();
				}
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
				$query->whereHas('userPp', function (Builder $subQuery) {
					$subQuery->whereNull('deleted_at');
				});
				$query->filterAdsTerritoryLocations($territoriesCode);
			})
			->with([
				'attributionAd',
				'attributionAd.adStatus',
				'landSeekAd',
				'landOfferAd',
				'jobOfferAd',
				'jobSeekAd',
				'departments',
				'departments.region',
				'regions',
				'cities',
				'cities.department'


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
				$query->whereHas('userPp', function (Builder $subQuery) {
					$subQuery->whereNull('deleted_at');
				});
				$query->whereHas('attributionAd', function (Builder $query) {
					if (auth()->user()->role == 2) {
						$query->where('user_advisor_id', '=', auth()->user()->id);
					} else if (auth()->user()->role >= 3) {
						$query->where('user_supervisor_id', '=', auth()->user()->id);
					}
				});
			})
			->orWhere(function (Builder $query) use ($territoriesCode) {
				$query->whereHas('userPp', function (Builder $subQuery) {
					$subQuery->whereNull('deleted_at');
				});
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
			->with($this->getDashboardsEagerLoading());
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
				$query->whereHas('attributionAd', function (Builder $subQuery) {
					$subQuery->whereNotNull('user_advisor_id');
					if (auth()->user()->role == 2) {
						$subQuery->where('user_advisor_id', '=', auth()->user()->id);
					} else if (auth()->user()->role >= 3) {
						$subQuery->where('user_supervisor_id', '=', auth()->user()->id);
					}
				});
				$query->whereHas('userPp', function (Builder $subQuery) {
					$subQuery->whereNull('deleted_at');
				});
				$query->whereNotNull('project_id');
			})
			->orWhere(function (Builder $query) use ($territoriesCode) {
				$query->whereNotNull('project_id');
				$query->whereHas('attributionAd', function (Builder $subQuery) {
					$subQuery->whereNotNull('user_advisor_id');
				});
				$query->whereHas('userPp', function (Builder $subQuery) {
					$subQuery->whereNull('deleted_at');
				});
				$query->whereHas('departments', function (Builder $query) use ($territoriesCode) {
					$query->whereIn('code', $territoriesCode);
				});
				$query->orWhereHas('cities', function (Builder $query) use ($territoriesCode) {
					$query->whereIn('department_code', $territoriesCode);
				});


			});

		$models
			->join('attribution_ads as a', 'a.ad_id', '=', 'ads.id')
			->orderByDesc('a.created_at')
			->with($this->getDashboardsEagerLoading());
		if ($toPaginate) {
			$ads = $models->paginate(15);
		} else {
			$ads = $models->get();
		}
		return $ads;
	}

	/**
	 * Find all not assigned projects in user (supervisor or advisor) territories
	 * @param array $territoriesCode
	 * @param bool $toPaginate
	 * @return LengthAwarePaginator|Builder[]|Collection
	 */
	public function allNotAssignedProjectsInTerritories(array $territoriesCode, bool $toPaginate)
	{
		/** @var Collection $model */
		$models = $this->entity
			->where(function (Builder $query) {
				$query->whereHas('userPp', function (Builder $subQuery) {
					$subQuery->whereNull('deleted_at');
				});
				$query->whereHas('attributionAd', function (Builder $subQuery) {
					$subQuery->whereNull('user_advisor_id');
					if (auth()->user()->role == 2) {
						$subQuery->where('user_advisor_id', '=', auth()->user()->id);
					} else if (auth()->user()->role >= 3) {
						$subQuery->where('user_supervisor_id', '=', auth()->user()->id);
					}
				});
				$query->whereNotNull('project_id');

			})
			->orWhere(function (Builder $query) use ($territoriesCode) {
				$query->whereNotNull('project_id');
				$query->whereHas('userPp', function (Builder $subQuery) {
					$subQuery->whereNull('deleted_at');
				});
				$query->whereHas('departments', function (Builder $subQuery) use ($territoriesCode) {
					$subQuery->whereIn('code', $territoriesCode);
				});
				$query->orWhereHas('cities', function (Builder $subQuery) use ($territoriesCode) {
					$subQuery->whereIn('department_code', $territoriesCode);
				});


				$query->whereHas('attributionAd', function (Builder $subQuery) {
					$subQuery->whereNull('user_advisor_id');
				});
			});

		$models
			->join('attribution_ads as a', 'a.ad_id', '=', 'ads.id')
			->orderByDesc('a.created_at')
			->with($this->getDashboardsEagerLoading());
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
					$subQuery->whereNotNull('published_on');
				});
			})
			->with('attributionAd')
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
		$queryAds = Ad::where(function (Builder $query) use ($territoryCodes) {
			$query->whereNotNull('project_id');
			$query->whereHas('userPp', function (Builder $subQuery) {
				$subQuery->whereNull('deleted_at');
			});
			$query->whereHas('attributionAd', function (Builder $subQuery) {
				if (auth()->user()->role == 2) {
					$subQuery->where('user_advisor_id', '=', auth()->user()->id);
				} else if (auth()->user()->role >= 3) {
					$subQuery->where('user_supervisor_id', '=', auth()->user()->id);
				}
			});
			$query->orWhereHas('departments', function (Builder $subQuery) use ($territoryCodes) {
				$subQuery->whereIn('code', $territoryCodes);
			});
			$query->orWhereHas('cities', function (Builder $subQuery) use ($territoryCodes) {
				$subQuery->whereIn('department_code', $territoryCodes);
			});
		})
			->where(function (Builder $query) use ($dates) {
				$query->whereHas('userPp', function (Builder $subQuery) {
					$subQuery->whereNull('deleted_at');
				});
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
		$ads = $queryAds->with($this->getDashboardsEagerLoading())->get();

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

	/**
	 * @param $selectedAdType
	 * @return Collection
	 */
	public function findAllPublishedWithLocations($selectedAdType): Collection
	{
		return $this->entity
			->whereHas('attributionAd', function (Builder $query) {
				$query->whereNotNull('published_on');
			})
			->filterAdTypes([$selectedAdType])
			->with($this->getLocationEagerLoading())
			->get();
	}

	/**
	 * @return int
	 */
	public function countAllPublished()
	{
		return $this->entity
			->whereHas('attributionAd', function (Builder $query) {
				$query->whereNotNull('published_on');
			})
			->count();
	}

	private function getFullEagerLoading()
	{
		return array_merge([
			'userPp',
			'adNotes',
			'adNotes.user',
			'documents',
			'documents.user',

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

			'attributionAd.userAdvisor',
		], $this->getLocationEagerLoading(), $this->getAttributionEagerLoading());
	}

	private function getDashboardsEagerLoading()
	{
		return array_merge([
			'userPp' => function ($query) {
				$query->withTrashed();
			},
			'landSeekAd',
			'landOfferAd',
			'jobOfferAd',
			'jobSeekAd'
		], $this->getLocationEagerLoading(), $this->getAttributionEagerLoading());
	}

	private function getLocationEagerLoading()
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

	private function getAttributionEagerLoading()
	{
		return [
			'project',
			'project.supportStage',
			'project.supportState',
			'project.projectStatus',
			'attributionAd',
			'attributionAd.adStatus',
		];
	}

    /**
     * @param Carbon $date
     * @return Ad[]|Collection
     */
    public function findAllByPublishedOnSince(Carbon $date)
    {
        return $this->entity
            ->whereHas('attributionAd', function (Builder $query) use ($date) {
                $query->whereDate('published_on', '<=', $date);
            })->get();
    }

    /**
     * @param Carbon $date
     * @return Ad[]|Collection
     */
    public function findAllNotAttributedSince(Carbon $date)
    {
        return $this->entity
            ->doesntHave('attributionAd')
            ->whereDate('updated_at', '<=', $date)
            ->get();
    }
}
