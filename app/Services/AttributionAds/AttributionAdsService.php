<?php

namespace App\Services\AttributionAds;

use App\Models\AdStatus;
use App\Models\AttributionAd;
use App\Models\Department;
use App\Models\Region;
use App\Notifications\ModerationPpNotification;
use App\Repositories\Ads\AdRepository;
use App\Repositories\AttributionAds\AttributionAdsRepository;
use App\Services\Locations\LocationService;
use App\Services\Users\UserService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;


/**
 * Class AttributionAdsService
 * @package App\Services\AttributionAds
 */
class AttributionAdsService
{
    protected $repository;
    protected $adRepository;
    protected $locationService;
    protected $userService;

    /**
     * AttributionAdsService constructor.
     * @param AttributionAdsRepository $attributionAdsRepository
     * @param AdRepository $adRepository
     * @param LocationService $locationService
     * @param UserService $userService
     */
    public function __construct(AttributionAdsRepository $attributionAdsRepository, AdRepository $adRepository, LocationService $locationService, UserService $userService)
    {
        $this->repository = $attributionAdsRepository;
        $this->adRepository = $adRepository;
        $this->locationService = $locationService;
        $this->userService = $userService;
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findAllByUserModeratorTerritories()
    {
        $moderatorLocationTerritoriesCodes = $this->userService->getCurrentUserTerritoryDepartments();
        return $this->repository->findAllByModeratorIdAndTerritories($moderatorLocationTerritoriesCodes);
    }

    /**
     * @param int $adId
     * @return bool
     */
    public function moderatorIsChargeOfAdModeration(int $adId): bool
    {
        $moderatorIsChargeOfAdModeration = false;
        $ad = $this->adRepository->find($adId);
        if ($ad->attributionAd && auth()->user()->id === $ad->attributionAd->user_moderator_id) {
            return $moderatorIsChargeOfAdModeration = true;
        }

        $moderatorLocationTerritoriesCodes = $this->userService->getCurrentUserTerritoryDepartments();
        $adDepartmentsCodes = [];
        $adDepartmentsCodesInCities = [];

        if ($ad->departments->count() > 0) {
            $adDepartmentsCodes = $ad->departments->map(function ($item) {
                return $item['code'];
            })->toArray();
        }
        if ($ad->cities->count() > 0) {
            $adDepartmentsCodesInCities = $ad->cities->map(function ($item) {
                return $item['department_code'];
            })->toArray();
        }
        $adTerritoriesCodes = array_merge($adDepartmentsCodes, $adDepartmentsCodesInCities);
        $intersectTerritoriesCodes = array_intersect($adTerritoriesCodes, $moderatorLocationTerritoriesCodes);

        if (count($intersectTerritoriesCodes) > 0) {
            $moderatorIsChargeOfAdModeration = true;
        }

        return $moderatorIsChargeOfAdModeration;
    }

    /**
     * Find all attributions ads published since specific number of month
     * @param Carbon $date
     * @return AttributionAd[]|Collection
     */
    public function findAllPublishedSince(Carbon $date)
    {
        return $this->repository->findAllApprovedAndPublishedSince($date);
    }


    /**
     * @return int
     */
    public function countAllAdsToModerateForLoggedModerator()
    {
        $pendingModerationStatus = AdStatus::where('id', '=', AdStatus::PENDING_MODERATION_STATUS_ID)->first();
        return $this->repository->findAllByUserIdAndStatusId($pendingModerationStatus->id, auth()->user()->id)->count();
    }


    /**
     * Attribution ads filters for moderators dashboard
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function showForModerators(Request $filters)
    {
        $attributionAds = $this->filter($filters);
        return $attributionAds;
    }

    /**
     * @param Request $filters
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filter(Request $filters)
    {
        $attributionAds = collect();
        //START QUERY
        $attributionAdsFiltered = (new AttributionAd)->newQuery();
        //Filter ads based on moderation attribution and moderator territories
        $moderatorTerritoriesCodes = $this->userService->getCurrentUserTerritoryDepartments();
        $attributionAdsFiltered->where(function (Builder $query) use ($moderatorTerritoriesCodes) {
            $query->where(function (Builder $subQuery) {
                $subQuery->whereNotNull('ad_status_id');
                $subQuery->where("user_moderator_id", '=', auth()->id());
                $subQuery->whereHas('ad', function (Builder $q) {
                    $q->whereNull('project_id');
                    $q->whereHas('userPp', function (Builder $builder) {
                        $builder->whereNull('deleted_at');
                    });
                });
            });
            $query->orWhere(function (Builder $subQuery) use ($moderatorTerritoriesCodes) {
                $subQuery->whereNotNull('ad_status_id');
                $subQuery->whereHas('ad', function (Builder $subQuery) use ($moderatorTerritoriesCodes) {
                    $subQuery->whereNull('project_id');
                    $subQuery->whereHas('userPp', function (Builder $q) {
                        $q->whereNull('deleted_at');
                    });
                    $subQuery->whereHas('departments', function (Builder $q) use ($moderatorTerritoriesCodes) {
                        $q->whereIn('code', $moderatorTerritoriesCodes);
                    });
                    $subQuery->orWhereHas('cities', function (Builder $q) use ($moderatorTerritoriesCodes) {
                        $q->whereIn('department_code', $moderatorTerritoriesCodes);
                    });
                });
            });
        });


        //Additional filters  : filter by surface range
        if ($filters->has('surfaces_research')) {
            if (!is_null($filters->input('surfaces_research')) && $filters->input('surfaces_research') > 0) {
                $attributionAdsFiltered->whereHas('ad', function (Builder $query) use ($filters) {
                    $query->filterWhereHasLandSeekAdOrWhereHasLandOfferAd('surface_range_max', 'surface', '<=', $filters->input('surfaces_research'));
                });
            }
        }
        //Additional filters  : filter by min_price
        if ($filters->has('price_min')) {
            if (!is_null($filters->input('price_min'))) {
                $attributionAdsFiltered->whereHas('ad', function (Builder $query) use ($filters) {
                    $query->filterWhereHasLandSeekAdOrWhereHasLandOfferAd('price_max', 'price', '>=', $filters->input('price_min'));
                });
            }
        }
        //Additional filters  : filter by max_price
        if ($filters->has('price_max')) {
            if (!is_null($filters->input('price_max'))) {
                $attributionAdsFiltered->whereHas('ad', function (Builder $query) use ($filters) {
                    $query->filterWhereHasLandSeekAdOrWhereHasLandOfferAd('price_max', 'price', '<=', $filters->input('price_max'));
                });
            }
        }
        //Additional filters  : filter by production_genres
        if ($filters->has('production_genres')) {
            if (!is_null($filters->input('production_genres'))) {
                $attributionAdsFiltered->whereHas('ad', function (Builder $query) use ($filters) {
                    $query->where(function (Builder $query) use ($filters) {
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
                });
            }
        }
        //Additional filters  : filter by bio_certification
        if ($filters->has('bio_certifications')) {
            if (!is_null($filters->input('bio_certifications'))) {
                $attributionAdsFiltered->whereHas('ad', function (Builder $builder) use ($filters) {
                    $builder->where(function (Builder $query) use ($filters) {
                        $query->whereHas('landOfferAd.bioCertifications', function (Builder $query) use ($filters) {
                            $query->whereIn('bio_certifications.id', $filters->input('bio_certifications'));
                        });
                    });
                });
            }
        }

        //Filter attribution ads based on their locations if requested
        if ($filters->has('locations')) {
            $locations = $filters->input('locations');
//			TODO delete if research by cities is not necessary anymore
//			if (array_key_exists('cities', $locations)) {
//				if (!is_null($filters->input('radius_research'))) {
//					$cityIds = $this->locationService->getCitiesInRadius($locations['cities'], $filters->input('radius_research'));
//					$attributionAdsFiltered->filterLocations('ad.cities', $cityIds);
//				} else {
//					$attributionAdsFiltered->filterLocations('ad.cities', $locations['cities']);
//				}
            //If one or more departments are selected, get all ads located in departments and cities in departments

            if (array_key_exists('departments', $locations)) {
                $departmentsCode = Department::whereIn('id', $locations['departments'])->get('code')->toArray();
                $attributionAdsFiltered->where(function (Builder $query) use ($locations, $departmentsCode) {
                    $query->filterLocations('ad.departments', $locations['departments']);
                    $query->filterSubLocations('ad.cities', $departmentsCode, 'cities.department_code');
                });

                //If one or more regions are selected, get all ads located in regions, all ads in departments inside regions and cities in departments
            }
            if (array_key_exists('regions', $locations)) {
                $regionsCodes = Region::whereIn('id', $locations['regions'])->get('code')->toArray();
                $departmentsCode = Department::whereIn('region_code', $regionsCodes)->get('code')->toArray();
                $attributionAdsFiltered->where(function (Builder $query) use ($locations, $regionsCodes, $departmentsCode) {
                    $query->filterLocations('ad.regions', $locations['regions']);
                    $query->filterSubLocations('ad.departments', $regionsCodes, 'departments.region_code');
                    $query->filterSubLocations('ad.cities', $departmentsCode, 'cities.department_code');
                });

            }
        }

        //If a range of submitting date is selected, filter attribution ads based on creation date
        if (!is_null($filters->input('date_from')) && !is_null($filters->input('date_to'))) {
            $dateStartFormatted = DateTime::createFromFormat('d/m/Y', (string)$filters->input('date_from'))->format('Y-m-d');
            $dateEndFormatted = DateTime::createFromFormat('d/m/Y', (string)$filters->input('date_to'))->format('Y-m-d');
            $attributionAdsFiltered->whereBetween('attribution_ads.created_at', [$dateStartFormatted, $dateEndFormatted . " 23:59:59"]);
        }

        //If one or many ad status are selected, filter attribution ads based on their status
        if ($filters->has('ad_statuses')) {

            $attributionAdsFiltered->whereIn('ad_status_id', $filters->input('ad_statuses'));
        }

        //Filter ads based on their types if requested
        if ($filters->has('ad_type')) {
            $attributionAdsFiltered->filterAdTypes($filters->input('ad_type'), 'ad.');
        }

        //Filter attribution ads if research ads by keywords
        if (!is_null($filters->input('ad_keywords'))) {
            $attributionAdsFiltered->whereHas('ad', function (Builder $query) use ($filters) {
                $query->where(function (Builder $query) use ($filters) {
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
                    $query->orWhere(function (Builder $subQuery) use ($filters) {
                        $subQuery->whereHas('userPp', function (Builder $builder) use ($filters) {
                            $builder->where('name', 'like', '%' . $filters->input('ad_keywords') . '%');
                            $builder->orWhere('first_name', 'like', '%' . $filters->input('ad_keywords') . '%');
                            $builder->orWhere('email', 'like', '%' . $filters->input('ad_keywords') . '%');

                        });
                    });

                });
            });
        }

        //Handling sort of research results
        if ($filters->has('order') && $filters->has('sort')) {
            if ($filters->input('sort') === 'date') {
                $attributionAdsFiltered->orderBy('created_at', $filters->input('order'));
            } else if ($filters->input('sort') === 'title') {
                $attributionAdsFiltered
                    ->join('ads', 'attribution_ads.id', '=', 'ads.id')
                    ->orderBy($filters->input('sort'), $filters->input('order'));

            } else if ($filters->input('sort') === 'name') {
                $attributionAdsFiltered
                    ->select('attribution_ads.*')
                    ->join('ads as a1', 'attribution_ads.ad_id', '=', 'a1.id')
                    ->join('users', 'users.id', '=', 'a1.user_pp_id')
                    ->orderBy('first_name', $filters->input('order'));

            } else if ($filters->input('sort') === 'ad_statuses.name') {
                $attributionAdsFiltered
                    ->join('ad_statuses', 'attribution_ads.ad_status_id', '=', 'ad_statuses.id')
                    ->orderBy('name', $filters->input('order'));
            } else if ($filters->input('sort') === 'project_statuses.name') {
                $attributionAdsFiltered
                    ->select('attribution_ads.*')
                    ->join('ads as a1', 'attribution_ads.ad_id', '=', 'a1.id')
                    ->leftJoin('projects as p1', 'p1.id', '=', 'a1.project_id')
                    ->leftJoin('project_statuses', 'p1.project_status_id', 'project_statuses.id')
                    ->orderBy('name', $filters->input('order'));
            }
        } else {
            $attributionAdsFiltered->orderByDesc('created_at');
        }
        $attributionAds = $attributionAdsFiltered
            ->with($this->getEagerLoading())
            ->paginate(15);
        return $attributionAds;
    }

    /**
     * @return array
     */
    private function getEagerLoading()
    {
        return [
            'ad',
            'ad.userPp',
            'adStatus',
            'ad.project.projectStatus',

            'ad.cities',
            'ad.cities.department',
            'ad.cities.department.region',
            'ad.departments',
            'ad.departments.region',
            'ad.regions',
            'ad.regions.departments',
            'ad.regions.departments.cities',

            'ad.landSeekAd',
            'ad.landOfferAd',
            'ad.jobOfferAd'
        ];
    }

    /**
     * @param int $attributionAdId
     * @return mixed
     */
    public function acceptAd(int $attributionAdId)
    {
        /** @var AttributionAd $attributionAd */
        $attributionAd = $this->repository->find($attributionAdId);
        //TODO if the pp want a support from Tdl, a special method as to be created.The moderator doesn't take part of the attribution process.
        //If on the territory related to the ad, there is advisors dedicated to specific departments, the ad is automatically attributed to the advisor and we create a project related to the ad.
        //$toAssignStatus = AdStatus::where('id', '=',AdStatus::APPROVE_ID)->first();
        //$attributionAd->ad_status_id = $toAssignStatus->id;
        //$supportStage = SupportStage::where('id', '=', SupportStage::FIRST_CONTACT_ID)->first();
        //$supportState = SupportState::where('id', '=', SupportStage::TO_HANDLE_ID)->first();
        //$attributionAd->ad->project()->create(['support_stage_id'=> $supportStage, 'support_state_id' => $supportState]);

        //Else, by default, the ad is attributed to an supervisor based on his territory saved in Salesforce . If there is many supervisors, one supervisor is pick randomly.
        //$toAssignStatus = AdStatus::where('id', '=', AdStatus::APPROVE_ID)->first();
        //$attributionAd->ad_status_id = $toAssignStatus->id;
        //$unassistedStatus = ProjectStatus::where('id', '=', ProjectStatus::UNASSISTED_ID)->first();
        //$attributionAd->ad->project()->create(['project_status_id'=> $unassistedStatus]);
        //$supervisor = User::where('role', '=', 3)->inRandomOrder()->first();
        //$attributionAd->user_supervisor_id = $supervisor->id;

        //If the pp doesn't need a support from Tdl, the ad is validated and published
        $attributionAd->ad_status_id = AdStatus::APPROVE_ID;
        $attributionAd->published_on = Carbon::now();
        $data = [
            'message' => 'Votre annonce a été validée par l\'équipe d\'Objectif Terres et est désormais publiée ! ',
            'action' => 'Consulter votre annonce',
            'url' => '/annonces/' . $attributionAd->ad->id,
        ];

        $attributionAd->ad->userPp->notify(new ModerationPpNotification($data));

        if ($attributionAd->refusal_type_id) {
            $attributionAd->refusal_type_id = null;
        }
        $attributionAd->save();

        $ad = $this->adRepository->find($attributionAd->ad->id);
        $ad->is_draft = 0;
        $ad->save();

        return $attributionAd;
    }

    public function modifyAd(int $attributionAdId)
    {
        $attributionAd = $this->repository->find($attributionAdId);
        $pendingStatus = AdStatus::where('id', '=', AdStatus::PENDING_ID)->first();
        $attributionAd->ad_status_id = $pendingStatus->id;
        $attributionAd->save();

        $ad = $this->adRepository->find($attributionAd->ad->id);
        $ad->is_draft = 1;
        $ad->save();

        //TODO url is the link to the form form modifiy the ad
        $data = [
            'message' => 'Votre annonce nécessite quelques modifications pour être publiée ! Consulter votre messagerie pour plus d\'informations.',
            'action' => 'Consulter votre messagerie',
            'url' => '/mon-espace/messagerie',
        ];
        $ad->userPp->notify(new ModerationPpNotification($data));
        return $attributionAd;
    }

    public function rejectAd(array $data)
    {
        $attributionAd = $this->repository->find($data['attribution_ad_id']);
        $rejectStatus = AdStatus::where('id', '=', AdStatus::REFUSE_ID)->first();
        $attributionAd->ad_status_id = $rejectStatus->id;
        $attributionAd->refusal_type_id = $data['refusal_type_id'];
        $attributionAd->refused_on = Carbon::now();
        $attributionAd->save();
        $data = [
            'message' => 'Votre annonce n\'a pas été acceptée par l\'équipe d\'Objectif Terres. Consulter votre messagerie pour plus d\'informations.',
            'action' => 'Consulter votre messagerie',
            'url' => '/mon-espace/messagerie',
        ];
        $attributionAd->ad->userPp->notify(new ModerationPpNotification($data));

        if ($attributionAd->ad->is_draft === 1) {
            $ad = $this->adRepository->find($attributionAd->ad->id);
            $ad->is_draft = 0;
            $ad->save();
        }
        return $attributionAd;

    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getListOfMonthInYear(): Collection
    {
        $period = CarbonPeriod::create(Carbon::now()->startOfYear(), '1 month', Carbon::now()->endOfYear());
        $listOfMonth = collect();
        foreach ($period as $date) {
            $listOfMonth[$date->localeMonth] = collect();
        }
        return $listOfMonth;
    }
}
