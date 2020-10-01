<?php namespace App\Repositories\Ads;

use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\AttributionAd;
use App\Models\City;
use App\Models\Department;
use App\Models\Region;
use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
	 * Creates an ad.
	 *
	 * @param int
	 * @param array
	 * @return Ad
	 * @throws \Throwable
	 */
	public function createForUser(array $data, $userId): Ad
	{
		$ad = new Ad();
		$ad->user_pp_id = $userId;

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
		if (!is_a($ad, Ad::class)) {
			$ad = $this->find($ad);
		}
		$this->save($ad, $data);
		return $ad;
	}

	/**
	 * @param Ad $ad
	 * @param array $data
	 */
	private function save(Ad $ad, array $data)
	{
		$ad->fill($data);

		$ad->save();

		foreach (["cities", "departments", "regions"] as $locationableType) {
			$locationables = $data["locationable"][$locationableType] ?? [];

			if (count($locationables)) {
				$extraFields = [];
				if (isset($data["locationable_radius"])) {
					$extraFields = ["radius" => $data["locationable_radius"]];
				}

				/** @var MorphToMany $locationableEntityQuery */
				$locationableEntityQuery = $ad->$locationableType();

				$locationableEntityQuery->sync($locationables, $extraFields);
			}
		}
		if (!empty($data["documents_ids"]) && is_array($data["documents_ids"])) {
			$ad->documents()->sync($data["documents_ids"]);
		}

		$ad->refresh();
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
	 * @param array $conditions
	 * @return Collection
	 */
	public function allByIdUser($idUser, $conditions = []): Collection
	{
		$query = $this->entity
			->where(["user_pp_id" => $idUser])
			->with($this->getDashboardsEagerLoading())
			->orderByDesc('id');

		foreach ($conditions as $column => $value) {
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
	 * @param array $territoriesIds
	 * @param bool $toPaginate
	 * @return LengthAwarePaginator|Builder[]|Collection
	 */
	public function allInTerritories(array $territoriesCode, array $territoriesIds, bool $toPaginate)
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
						$query->whereNotNull('user_advisor_id');
						$query->orWhere('user_advisor_id', '=', auth()->user()->id);
					} else if (auth()->user()->role >= 3) {
						$query->where('user_supervisor_id', '=', auth()->user()->id);
					}
				});
			})
			->filterSupportRequestRegionId($territoriesIds, auth()->user()->role)
			->orWhere(function (Builder $query) use ($territoriesCode) {
				$query->whereNull('project_id');
				$query->whereHas('userPp', function (Builder $subQuery) {
					$subQuery->whereNull('deleted_at');
				});
				$query->orWhereHas('regions', function (Builder $builder) use ($territoriesCode) {
					$builder->whereHas('departments', function (Builder $q) use ($territoriesCode) {
						$q->whereIn('code', $territoriesCode);
					});
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
	 * @param array $userLocationTerritoryRegionsId
	 * @param array $territoriesCode
	 * @param bool $toPaginate
	 * @return LengthAwarePaginator|Builder[]|Collection
	 */
	public function allProjectsInTerritories(array $territoriesCode, array $userLocationTerritoryRegionsId, bool $toPaginate)
	{
		/** @var Collection $model */
		$models = $this->entity
			->where(function (Builder $query) {
				$query->whereHas('attributionAd', function (Builder $subQuery) {
					$subQuery->whereNull('ad_status_id');
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
			->filterSupportRequestRegionId($userLocationTerritoryRegionsId, auth()->user()->role)

			//	TODO delete if this method not necessary anymore
			// previous query when support_request_territory_id didn't exist
			->orWhere(function (Builder $query) use ($territoriesCode) {

				$query->whereHas('attributionAd', function (Builder $subQuery) {
					$subQuery->whereNotNull('user_advisor_id');
					$subQuery->whereNull('ad_status_id');

				});
				$query->whereHas('userPp', function (Builder $subQuery) {
					$subQuery->whereNull('deleted_at');
				});
				$query->where(function (Builder $query) use ($territoriesCode) {
					$query->whereHas('regions', function (Builder $subQuery) use ($territoriesCode) {
						$subQuery->whereHas('departments', function (Builder $builder) use ($territoriesCode) {
							$builder->whereIn('code', $territoriesCode);
						});
					});
					$query->orWhereHas('departments', function (Builder $query) use ($territoriesCode) {
						$query->whereIn('code', $territoriesCode);
					});
					$query->orWhereHas('cities', function (Builder $query) use ($territoriesCode) {
						$query->whereIn('department_code', $territoriesCode);
					});
				});
				$query->whereNotNull('project_id');
			});

		$models
			->select('ads.*')
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
	 * @param array $territoriesIds
	 * @param array $territoryCodes
	 * @param bool $toPaginate
	 * @return LengthAwarePaginator|Builder[]|Collection
	 */
	public function allNotAssignedProjectsInTerritories(array $territoriesIds, array $territoryCodes, bool $toPaginate)
	{

		/** @var Collection $model */
		$models = $this->entity
			->where(function (Builder $builder) use ($territoriesIds, $territoryCodes) {
				$builder->where(function (Builder $query) {
					$query->whereHas('userPp', function (Builder $subQuery) {
						$subQuery->whereNull('deleted_at');
					});
					$query->whereHas('attributionAd', function (Builder $subQuery) {
						$subQuery->whereNull('user_advisor_id');
						$subQuery->whereNull('ad_status_id');
						if (auth()->user()->role == 2) {
							$subQuery->where('user_advisor_id', '=', auth()->user()->id);
						} else if (auth()->user()->role >= 3) {
							$subQuery->where('user_supervisor_id', '=', auth()->user()->id);
						}
					});
					$query->whereNotNull('project_id');

				});
				$builder->filterSupportRequestRegionId($territoriesIds, auth()->user()->role);
				//	TODO delete if this method not necessary anymore
				//previous system when column support_region_id_region did not exist
				$builder->orWhere(function (Builder $query) use ($territoryCodes) {
//					$query->whereNull('support_request_territory_id');
					$query->whereNotNull('project_id');
					$query->whereHas('attributionAd', function (Builder $subQuery) {
						$subQuery->whereNull('user_advisor_id');
						$subQuery->whereNull('ad_status_id');
					});
					$query->where(function (Builder $query) use ($territoryCodes) {
						$query->whereHas('userPp', function (Builder $subQuery) {
							$subQuery->whereNull('deleted_at');
						});
						$query->whereHas('regions', function (Builder $subQuery) use ($territoryCodes) {
							$subQuery->whereHas('departments', function (Builder $builder) use ($territoryCodes) {
								$builder->whereIn('code', $territoryCodes);
							});
						});
						$query->orWhereHas('departments', function (Builder $subQuery) use ($territoryCodes) {
							$subQuery->whereIn('code', $territoryCodes);
						});
						$query->orWhereHas('cities', function (Builder $subQuery) use ($territoryCodes) {
							$subQuery->whereIn('department_code', $territoryCodes);
						});
					});

				});
			});
		$models
			->select('ads.*')
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
	 * @param array $territoriesIds
	 * @param array|null $dates
	 * @return Builder[]|Collection
	 */
	public function findAllByUserTerritoriesAndDates(array $territoryCodes, array $territoriesIds, array $dates)
	{
		$queryAds = Ad::where(function (Builder $query) use ($territoryCodes, $territoriesIds) {
			$query->whereNotNull('project_id');
			$query->whereHas('userPp', function (Builder $subQuery) {
				$subQuery->whereNull('deleted_at');
			});
			$query->where(function (Builder $builder) {
				$builder->whereHas('attributionAd', function (Builder $subQuery) {
					if (auth()->user()->role == 2) {
						$subQuery->where('user_advisor_id', '=', auth()->user()->id);
					} else if (auth()->user()->role >= 3) {
						$subQuery->where('user_supervisor_id', '=', auth()->user()->id);
					}
				});
			});
			$query->orWhere(function (Builder $builder) use ($territoryCodes) {
				$builder->whereNotNull('project_id');
				$builder->orWhereHas('regions', function (Builder $subQuery) use ($territoryCodes) {
					$subQuery->whereHas('departments', function (Builder $builder) use ($territoryCodes) {
						$builder->whereIn('code', $territoryCodes);
					});
				});
				$builder->whereHas('departments', function (Builder $subQuery) use ($territoryCodes) {
					$subQuery->whereIn('code', $territoryCodes);
				});
				$builder->orWhereHas('cities', function (Builder $subQuery) use ($territoryCodes) {
					$subQuery->whereIn('department_code', $territoryCodes);
				});
			});
			$query->filterSupportRequestRegionId($territoriesIds, auth()->user()->role);
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
	 * @param bool $toPaginate
	 * @return Ad[]|LengthAwarePaginator|Builder[]|Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
	 */
	public function findAllPublished(bool $toPaginate)
	{
		$ads = $this->entity
			->whereHas('attributionAd', function (Builder $query) {
				$query->whereNotNull('published_on');
				$query->where('ad_status_id', '=', AdStatus::APPROVE_ID);
			})
			->whereNull('project_id')
			->with('landSeekAd',
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
				'attributionAd');
		if ($toPaginate === true) {
			return $ads->paginate(15);
		}
		return $ads->get();
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

	/**
	 * @param Request $filters
	 * @param int $roleUser
	 * @param array $userTerritories
	 * @param array $userTerritoriesRegionsId
	 * @param bool $toPaginate
	 * @return Ad[]|LengthAwarePaginator|Builder[]|Collection
	 */
	public function filterAds(Request $filters, int $roleUser, array $userTerritories, array $userTerritoriesRegionsId, bool $toPaginate)
	{
		//TODO move this method to the related repository
		//START QUERY
		$adsFiltred = (new Ad())->newQuery();

		//Remove all trashed users
		$adsFiltred->whereHas('userPp', function (Builder $query) {
			$query->whereNull('deleted_at');
		});

		if (Route::currentRouteName() === "advisor.show" || Route::currentRouteName() === "advisor.export") {
			//Remove all support request that are not attributed to anyone by the supervisor in advisors dashboard
			$adsFiltred->where(function (Builder $query) {
				$query->where(function (Builder $subQuery) {
					$subQuery->whereNull('project_id');
				});
				$query->orWhere(function (Builder $subQuery) {
					$subQuery->whereNotNull('project_id');
					$subQuery->whereHas('attributionAd', function (Builder $query) {
						$query->whereNotNull('user_advisor_id');
						$query->whereNull('ad_status_id');
					});
				});
			});
		}

		//Additional filters  : filter by surface range
		if ($filters->has('surfaces_research')) {
			if (!is_null($filters->input('surfaces_research'))) {
				$adsFiltred->filterWhereHasLandSeekAdOrWhereHasLandOfferAd('surface_range_max', 'surface', '<=', $filters->input('surfaces_research'));
			}
		}
		//Additional filters  : filter by min_price
		if ($filters->has('price_min')) {
			if (!is_null($filters->input('price_min'))) {
				$adsFiltred->filterWhereHasLandSeekAdOrWhereHasLandOfferAd('price_max', 'price', '>=', $filters->input('price_min'));
			}
		}
		//Additional filters  : filter by max_price
		if ($filters->has('price_max')) {
			if (!is_null($filters->input('price_max'))) {
				$adsFiltred->filterWhereHasLandSeekAdOrWhereHasLandOfferAd('price_max', 'price', '<=', $filters->input('price_max'));
			}
		}
		//Additional filters  : filter by production_genres
		if ($filters->has('production_genres')) {
			if (!is_null($filters->input('production_genres'))) {
				$adsFiltred->where(function (Builder $query) use ($filters) {
					$query->whereHas('landSeekAd.productionGenres', function (Builder $query) use ($filters) {
						$query->whereIn('production_genres.id', $filters->input('production_genres'));
					})
						->orWhereHas('landOfferAd.productionGenres', function (Builder $query) use ($filters) {
							$query->whereIn('production_genres.id', $filters->input('production_genres'));
						})
						->orWhereHas('landSeekAd.productionGenresPossible', function (Builder $query) use ($filters) {
							$query->whereIn('production_genres.id', $filters->input('production_genres'));
						})
						->orWhereHas('landOfferAd.productionGenresPossible', function (Builder $query) use ($filters) {
							$query->whereIn('production_genres.id', $filters->input('production_genres'));
						});
				});
			}
		}
		//Additional filters  : filter by bio_certification
		if ($filters->has('bio_certifications')) {
			if (!is_null($filters->input('bio_certifications'))) {
				$adsFiltred->where(function (Builder $query) use ($filters) {
					$query->whereHas('landOfferAd.bioCertifications', function (Builder $query) use ($filters) {
						$query->whereIn('bio_certifications.id', $filters->input('bio_certifications'));
					});
				});
			}
		}


		//Filter result by types : display ads or projects or both
		if ($filters->has('ads_show') && (!$filters->has('projects_show'))) {
			$adsFiltred->whereNull('project_id');
		} elseif ($filters->has('projects_show') && (!$filters->has('ads_show'))) {
			$adsFiltred->whereNotNull('project_id');
		}

		//Filter results by project attribution status
		if ($filters->has('project_attribution')) {
			$adsFiltred->whereNotNull('project_id');
			$adsFiltred->where(function (Builder $builder) use ($filters) {
				$builder->whereHas('attributionAd', function (Builder $subBuilder) use ($filters) {
					if (in_array('true', $filters->input('project_attribution'))) {
						$subBuilder->whereNotNull('user_advisor_id');
					} elseif (in_array('false', $filters->input('project_attribution'))) {
						$subBuilder->whereNull('user_advisor_id');
					}
				});
			});
		}

		//Filter projects based on their locations if requested
		if ($filters->has('locations')) {
			$locations = $filters->input('locations');
			//If one or more departments are selected, get all ads located in departments and cities in departments
			if (array_key_exists('departments', $locations)) {
				$departmentsCode = Department::whereIn('id', $locations['departments'])->get('code')->toArray();
				$adsFiltred->where(function (Builder $query) use ($locations, $departmentsCode) {
					$query->filterLocations('departments', $locations['departments']);
					$query->filterSubLocations('cities', $departmentsCode, 'cities.department_code');
				});
			}
			//If one or more regions are selected, get all ads located in regions, all ads in departments inside regions and cities in departments
			if (array_key_exists('regions', $locations)) {
				$regionsCodes = Region::whereIn('id', $locations['regions'])->get('code')->toArray();
				$departmentsCode = Department::whereIn('region_code', $regionsCodes)->get('code')->toArray();
				$adsFiltred->where(function (Builder $query) use ($locations, $regionsCodes, $departmentsCode) {
//					$query->whereNull('support_request_territory_id');
					$query->filterLocations('regions', $locations['regions']);
					$query->filterSubLocations('departments', $regionsCodes, 'departments.region_code');
					$query->filterSubLocations('cities', $departmentsCode, 'cities.department_code');
				});
			}
		}

		//If a range of submitting date is selected, filter attribution ads based on creation date
		if (!is_null($filters->input('date_from')) && !is_null($filters->input('date_to'))) {
			$dateStartFormatted = DateTime::createFromFormat('d/m/Y', (string)$filters->input('date_from'))->format('Y-m-d');
			$dateEndFormatted = DateTime::createFromFormat('d/m/Y', (string)$filters->input('date_to'))->format('Y-m-d');
			$adsFiltred->where(function (Builder $query) use ($dateStartFormatted, $dateEndFormatted) {
				$query->whereHas('attributionAd', function (Builder $subQuery) use ($dateStartFormatted, $dateEndFormatted) {
					$subQuery->whereBetween('created_at', [$dateStartFormatted, $dateEndFormatted . " 23:59:59"]);
				});
			});
		}

		//If one or many support stgaes are selected, filter  ads based on their support stages
		if ($filters->has('support_stages')) {
			$adsFiltred->whereHas('project', function (Builder $query) use ($filters) {
				$query->whereIn('support_stage_id', $filters->input('support_stages'));
			});
		}

		//If one or many support states are selected, filter  ads based on their support states
		if ($filters->has('support_states')) {
			$adsFiltred->whereHas('project', function (Builder $query) use ($filters) {
				$query->whereIn('support_state_id', $filters->input('support_states'));
			});
		}

		//If one or many project status are selected, filter  ads based on their project status
		if ($filters->has('project_statuses')) {
			$adsFiltred->whereHas('project', function (Builder $query) use ($filters) {
				$query->whereIn('project_status_id', $filters->input('project_statuses'));
			});
		}

		//Filter ads based on their types
		if ($filters->has('ad_type')) {
			$adsFiltred->filterAdTypes($filters->input('ad_type'), '');
		}

		//Filter ads by keywords
		if (!is_null($filters->input('ad_keywords'))) {
			$adsFiltred->where(function (Builder $query) use ($filters) {
				$query->where('title', 'like', '%' . $filters->input('ad_keywords') . '%');
				$query->orWhere('about_content', 'like', '%' . $filters->input('ad_keywords') . '%');
				$query->orWhere('about_project_content', 'like', '%' . $filters->input('ad_keywords') . '%');
				$query->orWhere(function (Builder $subQuery) use ($filters) {
					$subQuery->whereHas('landOfferAd', function (Builder $q) use ($filters) {
						$q->where('sau_description', 'like', '%' . $filters->input('ad_keywords') . '%');
						$q->orWhere('water_access_description', 'like', '%' . $filters->input('ad_keywords') . '%');
						$q->orWhere('test_description', 'like', '%' . $filters->input('ad_keywords') . '%');
						$q->orWhere(function (Builder $q) use ($filters) {
							$q->whereHas('building', function (Builder $r) use ($filters) {
								$r->where('description', 'like', '%' . $filters->input('ad_keywords') . '%');

							});
							$q->orWhereHas('house', function (Builder $r) use ($filters) {
								$r->where('description', 'like', '%' . $filters->input('ad_keywords') . '%');
							});
						});

					});
				});
				$query->orWhere(function (Builder $subQuery) use ($filters) {
					$subQuery->whereHas('landSeekAd', function (Builder $q) use ($filters) {
						$q->where('experience_farming', 'like', '%' . $filters->input('ad_keywords') . '%');
						$q->orWhere('land_description', 'like', '%' . $filters->input('ad_keywords') . '%');
					});
				});

			});
		}

		//Filter ads based on the role of the logged user
		$adsFiltred->where(function (Builder $query) use ($userTerritories, $userTerritoriesRegionsId, $roleUser) {
			$query->where(function (Builder $query) use ($userTerritoriesRegionsId, $roleUser) {
				$query->whereNotNull('support_request_territory_id');
				$query->whereIn('support_request_territory_id', $userTerritoriesRegionsId);
			});

			$query->orWhere(function (Builder $query) use ($userTerritories, $roleUser) {
				$query->whereNotNull('project_id');
				$query->whereHas('attributionAd', function (Builder $q) use ($roleUser) {
					$q->where('user_moderator_id', '=', auth()->id());
					if ($roleUser === 2) {
						$q->orWhere('user_advisor_id', '=', auth()->id());
					} elseif ($roleUser >= 3)
						$q->orWhere('user_supervisor_id', '=', auth()->id());
				});
			});
			$query->orWhere(function (Builder $query) use ($userTerritories) {
				$query->whereNull('project_id');
				$query->whereHas('regions', function (Builder $subQuery) use ($userTerritories) {
					$subQuery->whereHas('departments', function (Builder $builder) use ($userTerritories) {
						$builder->whereIn('code', $userTerritories);
					});
				});
				$query->orWhereHas('departments', function (Builder $query) use ($userTerritories) {
					$query->whereIn('code', $userTerritories);
				});
				$query->orWhereHas('cities', function (Builder $query) use ($userTerritories) {
					$query->whereIn('department_code', $userTerritories);
				});
			});
		});


		// Sort results
		if ($filters->has('order') && $filters->has('sort')) {
			if ($filters->input('sort') === 'date') {
				$adsFiltred->join('attribution_ads as a', 'a.ad_id', '=', 'ads.id')
					->orderBy('a.created_at', $filters->input('order'));
			} else if ($filters->input('sort') === 'title') {
				$adsFiltred
					->orderBy($filters->input('sort'), $filters->input('order'));

			} else if ($filters->input('sort') === 'name') {
				$adsFiltred
					->select('ads.*')
					->join('users', 'users.id', '=', 'ads.user_pp_id')
					->orderBy('first_name', $filters->input('order'));

			} else if ($filters->input('sort') === 'project_statuses.name') {
				$adsFiltred
					->select('ads.*')
					->leftJoin('projects as p1', 'p1.id', '=', 'ads.project_id')
					->leftJoin('project_statuses', 'p1.project_status_id', '=', 'project_statuses.id')
					->orderBy('name', $filters->input('order'));
			}
		} else {
			/**TODO find a way to group results first with projects and then ads. Each group has to be order by attribution_ads.created_at **/
			$adsFiltred
				->select('ads.*')
				->leftJoin('projects as p', 'p.id', '=', 'ads.project_id')
				->orderByDesc('p.created_at')
				->join('attribution_ads as a', 'a.ad_id', '=', 'ads.id')
				->orderByDesc('a.created_at');
		}

		$adsFiltred->with($this->getDashboardsEagerLoading());

		if ($toPaginate == true) {
			return $adsFiltred->paginate(15);
		} else {
			return $adsFiltred->get();
		}
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

	public function findAttributedAndNotDraftedByUserId(int $userId)
	{
		return $this->entity
			->whereHas('attributionAd')
			->where('is_draft', 0)
			->where('user_pp_id', $userId)
			->get();
	}

	public function findAdsAttributedAndNotDraftedByUserId(int $userId)
	{
		return $this->entity
			->whereHas('attributionAd')
			->where('is_draft', 0)
			->where('user_pp_id', $userId)
			->whereNull('project_id')
			->get();
	}

	private function getFullEagerLoading()
	{
		return array_merge([
			'project',
			'userPp',
			'userPp.departments',
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
			'attributionAd.userSupervisor',


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


}
