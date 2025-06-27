<?php namespace App\Services\Researches;


use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\City;
use App\Models\Department;
use App\Models\Region;
use App\Models\Research;
use App\Repositories\Ads\AdRepository;
use App\Repositories\Researches\ResearchRepository;
use App\Services\Locations\LocationService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use LaravelIdea\Helper\App\Models\_IH_Ad_QB;

class ResearchService
{
	public function __construct(private ResearchRepository $repository)
	{
	}


	/**
	 * @param Request $request
	 * @return mixed
	 * @throws \Throwable
	 */
	public function create(Request $request)
	{
		$url = (url()->previous());
		$urlParsed = parse_url($url);
		parse_str($urlParsed['query'], $urlQuery);
		if ($request->input('page')) {
			unset($urlQuery['page']);
		}
		$urlGet = http_build_query($urlQuery);

		$data = [];
		foreach ($request->input() as $item => $value) {
			$data[$item] = $value;
		}
		$data['url'] = '?' . $urlGet;
		$research = DB::transaction(function () use ($data) {
			$research = $this->repository->create($data);

			return $research;
		});

		return $research;
	}

	/**
	 * @param int $id
	 * @return Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function find(int $id)
	{
		$research = $this->repository->find($id);

		return $research;
	}

	/**
	 * @param int $id
	 * @return Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function findAllByUser(int $id)
	{
		$researches = $this->repository->findAllByUser($id);
		return $researches;
	}

	/**
	 * @return array
	 */
	public function findNewRelatedAds(): array
	{
		$researches = $this->repository->findAllResearchesWithAlertActive();
		$researchesWithNewAds = [];
		foreach ($researches as $research) {
			$ads = collect();
			$adsFilter = (new Ad)->newQuery();
			$adsFilter->filterAdTypes([$research->ad_type], '');

			if ($research->cities()->exists()) {
				$adsFilter->filterLocations('cities', $research->cities()->pluck('cities.id')->toArray());
			} else if ($research->departments()->exists()) {
				$adsFilter->filterLocations('departments', $research->departments()->pluck('departments.id')->toArray());
				$adsFilter->filterSubLocations('cities', $research->departments()->pluck('code')->toArray(), 'cities.department_code');

			}
			if ($research->offerGenres()->exists()) {
				$adsFilter->filterWhereHasIn($research->offerGenres()->pluck('offer_genres.id')->toArray(), $research->ad_type . '.offerGenres', 'offer_genre_id');
			}

			if (!is_null($research->surface_min)) {
				if ($research->ad_type === 'landSeekAd') {
					$adsFilter->whereHas($research->ad_type, function (Builder $query) use ($research) {
						$query->where('surface_range_min', '>=', $research->surface_min);
					});
				} else if ($research->ad_type === 'landOfferAd') {
					$adsFilter->whereHas($research->ad_type, function (Builder $query) use ($research) {
						$query->where('surface', '>=', $research->surface_min);
					});
				}
			}
			if (!is_null($research->surface_max)) {
				if ($research->ad_type === 'landSeekAd') {
					$adsFilter->whereHas($research->ad_type, function (Builder $query) use ($research) {
						$query->where('surface_range_max', '<=', $research->surface_max);
					});
				} else if ($research->ad_type === 'landOfferAd') {
					$adsFilter->whereHas($research->ad_type, function (Builder $query) use ($research) {
						$query->where('surface', '<=', $research->surface_max);
					});
				}
			}
			if (!is_null($research->price_min)) {
                if ($research->ad_type === 'landOfferAd') {
                    $adsFilter->whereHas($research->ad_type, function (Builder $query) use ($research) {
                        $query->where('price', '>=', $research->price_min);
                        $query->orWhere('rent_price', '>=', $research->price_min);
                    });
                }
			}
			if (!is_null($research->price_max)) {
                if ($research->ad_type === 'landOfferAd') {
                    $adsFilter->whereHas($research->ad_type, function (Builder $query) use ($research) {
                        $query->where('price', '<=', $research->price_max);
                        $query->orWhere('rent_price', '<=', $research->price_max);
                    });
                }
			}
			if (!is_null($research->has_houses)) {
				$adsFilter->filterWhereHasWhere($research->has_houses, $research->ad_type, '=', 'has_buildings');
			}
			if ($research->has_pics === 1) {
				$adsFilter->whereHas('documents', function (Builder $query) {
					$query->whereIn('type', ['image']);
				});
			}
			if ($research->productionGenres()->exists()) {
				$adsFilter->filterWhereHasIn($research->productionGenres()->pluck('production_genres.id')->toArray(), $research->ad_type . '.productionGenres', 'production_genres.id');
			}
			if ($research->bioCertifications()->exists()) {
				$adsFilter->filterWhereHasIn($research->bioCertifications()->pluck('bio_certifications.id')->toArray(), $research->ad_type . '.bioCertifications', 'bio_certifications.id');
			}
			if ($research->jobOfferTypes()->exists()) {
				$adsFilter->filterWhereHasIn($research->jobOfferTypes()->pluck('job_offer_types.id')->toArray(), $research->ad_type . '.jobOfferTypes', 'job_offer_types.id');
			}

			$adsFilter->whereHas('attributionAd', function (Builder $query) use ($research) {
				$query->where('published_on', '>', $research->updated_at);
			});
			$newAds = $adsFilter->get();

			if (!$newAds->isEmpty()) {
				$researchesWithNewAds[$research->id] = $newAds;
				$research->updated_at = Carbon::now();
				$research->save();
			}
		}

		return $researchesWithNewAds;
	}

	/**
	 * @param Request $filters
	 * @return array|Ad[]|Collection
	 */
	public function index(Request $filters)
	{
		$ads = $this->filter($filters, AdRepository::getVisitorEagerLoading());
		return $ads->paginate(15);
	}

    /**
     * @param Request $filters
     * @param null $with
     * @return Ad|Builder|_IH_Ad_QB
     */
	public function filter(Request $filters, $with = null)
	{
		$query = (new Ad)->newQuery();
        if($with) {
            $query->with($with);
        }
		//Filter by type of ads
		$adType = '';

		if ($filters->has('certified')) {
			$query->where('is_partner', '=', 1);
		}

		if ($filters->has('ad_category') && $filters->input('ad_category') === "all") {
			$query->whereHas('attributionAd', function (Builder $query) {
				$query->whereNotNull('published_on');
				$query->where('ad_status_id', '=', AdStatus::APPROVE_ID);
			})
				->whereNull('project_id');

		}

		if ($filters->has('ad_category')) {
			$adType = $filters->input('ad_category');
		} elseif ($filters->input('ad_category') !== "all" && !$filters->has('ad_category')) {
			abort(redirect()->back()->with('warning', 'Aucun catégorie d\'annonce séléctionnée'));
		}

        // filter by departments locations and all locations related to the departments selected
        $query->whereNull('project_id');
        if ($filters->has('cities_location_researches_ids')) {
            if (!is_null($filters->input('radius_research'))) {
                $cityIds = $this->getCitiesInRadius($filters->input('cities_location_researches_ids'), $filters->input('radius_research'));
                $query->filterLocations('cities', $cityIds);
            } else {
                $query->filterLocations('cities', $filters->input('cities_location_researches_ids'));
            }

        } // filter by departments locations and all locations related to the departments selected
        else if ($filters->has('departments')) {
            $departmentsCodes = Department::whereIn('id', $filters->input('departments'))->get('code')->toArray();
            $query->filterLocations('departments', $filters->input('departments'));
            $query->filterSubLocations('cities', $departmentsCodes, 'cities.department_code');
        } // filter by regions locations and all locations related to the regions selected
        else if ($filters->has('regions')) {
            if (!in_array(-1, $filters->input('regions'))) {
                $regionsCodes = Region::whereIn('id', $filters->input('regions'))->get('code')->toArray();
                $departmentsCodes = Department::whereIn('region_code', $regionsCodes)->get('code')->toArray();
                $query->filterLocations('regions', $filters->input('regions'));
                $query->filterSubLocations('departments', $regionsCodes, 'departments.region_code');
                $query->filterSubLocations('cities', $departmentsCodes, 'cities.department_code');
            }
        }

        if (!is_null($filters->input('surfaces_research_max')) && $filters->input('surfaces_research_max') !== "0" && $filters->input('surfaces_research_max') !== "100000000000") {
            if (in_array($adType, ['landOfferAd', 'associateOfferAd', 'landSeekAd'])) {
                $query->filterWhereHasWhere((int)$filters->input('surfaces_research_max'), $adType, '<=', 'surface');
            }
        }

        if (in_array($adType, ['landOfferAd', 'associateOfferAd'])) {
            if (!is_null($filters->input('price_min'))) {
                $query->whereHas($adType, function (Builder $query) use ($filters) {
                    $query->where('price', '>=', (int)$filters->input('price_min'));
                });
            }
            if (!is_null($filters->input('price_max'))) {
                $query->whereHas($adType, function (Builder $query) use ($filters) {
                    $query->where('price', '<=', (int)$filters->input('price_max'));
                });
            }
            if (!is_null($filters->input('fermage_min'))) {
                $query->whereHas($adType, function (Builder $query) use ($filters) {
                    $query->where('rent_price', '>=', (int)$filters->input('fermage_min'));
                });
            }
            if (!is_null($filters->input('fermage_max'))) {
                $query->whereHas($adType, function (Builder $query) use ($filters) {
                    $query->where('rent_price', '<=', (int)$filters->input('fermage_max'));
                });
            }
        }

        if ($filters->has('has_buildings') && $adType !== "all") {
            $query->filterWhereHasWhere($filters->input('has_buildings'), $adType, '=', 'has_buildings');
        }

        if ($filters->has('has_picture')) {
            $query->whereHas('documents', function (Builder $query) {
                $query->where('type', 'like', 'image/%');
            });

        }

        if($filters->has('installation')) {
            $query->filterWhereHasWhere($filters->input('installation'), $adType, '=', 'installation_type_id');
        }

        if($adType !== "all") {
            if ($filters->has('production_genres')) {
                $query->filterWhereHasIn($filters->input('production_genres'), $adType . '.productionGenres', 'production_genres.id');
            };

            if ($filters->has('bio_certifications')) {
                $query->filterWhereHasIn($filters->input('bio_certifications'), $adType . '.bioCertifications', 'bio_certifications.id');
            }


            if (!is_null($filters->input('jobOfferType'))) {
                $query->filterWhereHasWhere($filters->input('jobOfferType'), $adType . '.jobOfferTypes', '=', 'job_offer_types.id');
            }

            $query->filterAdTypes([$adType]);
        }

        $validatedStatus = AdStatus::where('id', '=', AdStatus::APPROVE_ID)->first();
        $query->filterWhereHasWhere($validatedStatus->id, 'attributionAd', '=', 'ad_status_id');
        $query->where("is_draft", '=', 0);

        //Filter ads by keywords
        if (!is_null($filters->input('keywords'))) {
            $query->where(function (Builder $query) use ($filters, $adType) {
                $query->where('title', 'like', '%' . $filters->input('keywords') . '%')
                    ->orWhere('about_content', 'like', '%' . $filters->input('keywords') . '%')
                    ->orWhere('about_project_content', 'like', '%' . $filters->input('keywords') . '%');

                if ($adType === 'landOfferAd') {
                    $query->orWhereHas('landOfferAd', function (Builder $q) use ($filters) {
                        $q->where(function (Builder $q) use ($filters) {
                            $q->where('sau_description', 'like', '%' . $filters->input('keywords') . '%')
                                ->orWhere('water_access_description', 'like', '%' . $filters->input('keywords') . '%')
                                ->orWhere('test_description', 'like', '%' . $filters->input('keywords') . '%')
                                ->orWhere(function (Builder $q) use ($filters) {
                                    $q->whereHas('building', function (Builder $r) use ($filters) {
                                        $r->where('description', 'like', '%' . $filters->input('keywords') . '%');
                                    })->orWhereHas('house', function (Builder $r) use ($filters) {
                                        $r->where('description', 'like', '%' . $filters->input('keywords') . '%');
                                    });
                                });
                        });
                    });
                }

                if($adType === 'associateOfferAd') {
                    $query->orWhereHas('associateOfferAd', function (Builder $q) use ($filters) {
                        $q->where('associate_description', 'like', '%' . $filters->input('keywords') . '%');
                        $q->where('experience_farming', 'like', '%' . $filters->input('keywords') . '%');
                    });
                }
            });
        }


        if($filters->has('water_access')) {
            $query->whereHas($adType, function (Builder $q) use ($filters) {
                $q->where('water_access', (int)$filters->get('water_access'));
            });
        }

        if($filters->has('formations')) {
            $query->filterWhereHasIn($filters->input('formations'), $adType . '.educationLevels', 'education_levels.id');
        }

        if($filters->has('experiences')) {
            $query->filterWhereHasIn($filters->input('experiences'), $adType . '.jobOfferTypes', 'job_offer_types.id');
        }


        if ($filters->has('offer_genres')) {
            $query->filterWhereHasIn($filters->input('offer_genres'), $adType . '.offerGenres', 'offer_genres.id');
        }

        if($filters->has('surfaces_research_min') && $filters->input('surfaces_research_min') !== "0") {
            if (in_array($adType, ['landOfferAd', 'associateOfferAd', 'landSeekAd'])) {
                $query->filterWhereHasWhere((int)$filters->input('surfaces_research_min'), $adType, '>=', 'surface');
            }
        }
        if($filters->has('surfaces_research_max') && $filters->input('surfaces_research_max') !== "0") {
            if (in_array($adType, ['landOfferAd', 'associateOfferAd', 'landSeekAd'])) {
                $query->filterWhereHasWhere((int)$filters->input('surfaces_research_max'), $adType, '<=', 'surface');
            }
        }


		if ($filters->has('order') && $filters->has('sort')) {
			if ($filters->input('sort') === 'date') {
				$query->join('attribution_ads', "ads.id", '=', "attribution_ads.ad_id")
					->orderBy('published_on', $filters->input('order'))
					->select('ads.*');
			} else {
				$adsTypeSelectedTableName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $adType)) . 's';
				$query->join($adsTypeSelectedTableName, 'ads.id', '=', $adsTypeSelectedTableName . '.ad_id')
					->orderBy($filters->input('sort'), $filters->input('order'))
					->select('ads.*');
			}
		} else {
			$query->join('attribution_ads', "ads.id", '=', "attribution_ads.ad_id")
				->orderByDesc('published_on')
				->select('ads.*');
		};

		return $query->distinct();
	}

    /**
     * @param $cityId
     * @param $radius
     * @return array
     */
    public function getCitiesInRadius ($cityId, $radius){
        $city = City::whereId($cityId)->first();
        $cities = DB::select(
            'SELECT id FROM (
                SELECT *,
                    (
                        (
                            (
                                acos(
                                    sin(( '.(float)$city->gps_lat.' * pi() / 180))
                                    *
                                    sin(( `gps_lat` * pi() / 180)) + cos(( '.(float)$city->gps_lat.' * pi() /180 ))
                                    *
                                    cos(( `gps_lat` * pi() / 180)) * cos((( '.(float)$city->gps_lng.' - `gps_lng`) * pi()/180)))
                            ) * 180/pi()
                        ) * 60 * 1.1515 * 1.609344
                    )
                as distance FROM `cities`
            ) myTable
            WHERE distance <= '.(int)$radius.';'
        );
        return array_column($cities, 'id');
    }

	/**
	 * @param Research $research
	 */
	public
	function deleteAlert(Research $research)
	{
		$research->has_alert = 0;
		$research->save();
	}

	/**
	 * @param Research $research
	 * @return mixed
	 */
	public
	function destroy(Research $research)
	{
		return $this->repository->delete($research->id);
	}

    public function getAllResearchesWithActiveAlertsOlderThan(Carbon $subDate): \LaravelIdea\Helper\App\Models\_IH_Research_C|array|\Illuminate\Database\Eloquent\Collection
    {
        return Research::where('has_alert', 1)
            ->where('created_at', '<', $subDate)
            ->get();
    }

    public function disableAlerts(\LaravelIdea\Helper\App\Models\_IH_Research_C|\Illuminate\Database\Eloquent\Collection|array $researches)
    {
        Research::whereIn('id', $researches->pluck('id'))->update(['has_alert' => 0]);
    }
}
