<?php namespace App\Services\Ads;

use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\City;
use App\Models\Department;
use App\Models\ProjectStatus;
use App\Models\Region;
use App\Models\SupportStage;
use App\Models\SupportState;
use App\Models\User;
use App\Repositories\Ads\AdRepository;
use App\Repositories\Ads\JobOfferAdRepository;
use App\Repositories\Ads\JobSeekAdRepository;
use App\Repositories\Ads\LandOfferAdRepository;
use App\Repositories\Ads\LandSeekAdRepository;
use App\Repositories\Ads\ProductionGenreRepository;
use App\Repositories\AttributionAds\AttributionAdsRepository;
use App\Repositories\Projects\ProjectsRepository;
use App\Services\AttributionAds\AttributionAdsService;
use App\Services\Users\UserService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/**
 * Class AdService
 * @package App\Services\Ads
 */
class AdService
{
    /**
     * @var AdRepository
     */
    protected $repository;
    /**
     * @var LandSeekAdRepository
     */
    protected $landSeekAdRepository;
    /**
     * @var LandOfferAdRepository
     */
    protected $landOfferAdRepository;
    /**
     * @var ProductionGenreRepository
     */
    protected $productionGenreRepository;
    /**
     * @var JobOfferAdRepository
     */
    protected $jobOfferAdRepository;
    /**
     * @var JobSeekAdRepository
     */
    protected $jobSeekAdRepository;
    /**
     * @var AttributionAdsRepository
     */
    protected $attributionAdsRepository;

    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var ProjectsRepository
     */
    protected $projectRepository;

    /**
     * @var AttributionAdsService
     */
    protected $attributionAdsService;

    /**
     * AdService constructor.
     * @param AdRepository $repository
     * @param AttributionAdsRepository $attributionAdsRepository
     * @param LandSeekAdRepository $landSeekAdRepository
     * @param LandOfferAdRepository $landOfferAdRepository
     * @param JobOfferAdRepository $jobOfferAdRepository
     * @param JobSeekAdRepository $jobSeekAdRepository
     * @param ProductionGenreRepository $productionGenreRepository
     * @param ProjectsRepository $projectRepository
     * @param UserService $userService
     * @param AttributionAdsService $attributionAdsService
     */
    public function __construct(
        AdRepository $repository,
        AttributionAdsRepository $attributionAdsRepository,
        LandSeekAdRepository $landSeekAdRepository,
        LandOfferAdRepository $landOfferAdRepository,
        JobOfferAdRepository $jobOfferAdRepository,
        JobSeekAdRepository $jobSeekAdRepository,
        ProductionGenreRepository $productionGenreRepository,
        ProjectsRepository $projectRepository,
        UserService $userService,
        AttributionAdsService $attributionAdsService
    )
    {
        $this->repository = $repository;
        $this->attributionAdsRepository = $attributionAdsRepository;
        $this->landSeekAdRepository = $landSeekAdRepository;
        $this->landOfferAdRepository = $landOfferAdRepository;
        $this->jobOfferAdRepository = $jobOfferAdRepository;
        $this->jobSeekAdRepository = $jobSeekAdRepository;
        $this->productionGenreRepository = $productionGenreRepository;
        $this->userService = $userService;
        $this->projectRepository = $projectRepository;
        $this->attributionAdsService = $attributionAdsService;
    }

    /**
     * @param User $user
     * @return User|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|Ad|null
     */
    public function getUserSupportRequest(User $user)
    {
        return $user->supportRequests()->first();
    }

    /**
     * @param array $data
     * @param bool $isSupportRequest
     * @return mixed
     * @throws \Throwable
     */
    public function requestPublishing(array $data, bool $isSupportRequest = false)
    {
        $isUpdate = !empty($data["id"]);

        DB::beginTransaction();

        $attributionAdData = [];

        if ($isSupportRequest) {
            // Create a project for this ad
            $project = $this->projectRepository->create([
                'support_stage_id' => SupportStage::FIRST_RECEPTION_ID,
                'support_state_id' => SupportState::TO_HANDLE_ID,
                'project_status_id' => ProjectStatus::EMERGING_ID,
            ]);
            $data["project_id"] = $project->id;
        }

        $data["is_draft"] = false;

        if ($isUpdate) {
            $ad = $this->repository->update($data["id"], $data);
        } else {
            $ad = $this->repository->create($data);
        }


        if ($isSupportRequest) {
            $pendingStatus = AdStatus::PENDING_ID;
            /*$advisor = $this->userService->findRandomByRoleAndRegion(3, $adRandomRegionId);
            if (!$advisor) {
                throw new \Exception("Aucun responsable n'a été trouvé dans votre région. Veuillez sauvegarder votre demande et nous contacter.");
            }
            $attributionAdData['user_supervisor_id'] = $advisor->id;*/
        } else {
            $adDepartmentCodes = $this->getAdDepartmentCodes($ad);
            $pendingStatus = AdStatus::PENDING_MODERATION_STATUS_ID;
            $availableModerators = $this->userService->findByRoleAndDepartments(1, $adDepartmentCodes);
            if($availableModerators->isEmpty()) {
                $availableModerators = $this->userService->findByRoleSuperiorThanAndDepartments(1, $adDepartmentCodes);
            }
            if ($availableModerators->isEmpty()) {
                throw new \Exception("Aucun modérateur n'a été trouvé dans votre région. Veuillez sauvegarder votre annonce et nous contacter.");
            }

            // If ad was attributed before, we'll get the same moderator if available
            if ($ad->attributionAd && $ad->attributionAd->userModerator &&
                $availableModerators->keyBy("id")->find($ad->attributionAd->user_moderator_id)) {
                    $moderator = $ad->attributionAd->userModerator;
            }
            else {
                /** @var User $moderator */
                $moderator = $availableModerators->random();
            }

            $attributionAdData['user_moderator_id'] = $moderator->id;
        }

        $attributionAdData['ad_status_id'] = $pendingStatus;
        $attributionAdData['ad_id'] = $ad->id;

        // Ad was already attributed before, and was not refused or archived; then we use the existing one
        if ($ad->attributionAd && !in_array($ad->attributionAd->adStatus->id, [AdStatus::REFUSE_ID, AdStatus::ARCHIVED_ID])) {
            $this->attributionAdsRepository->update($ad->attributionAd->id, $attributionAdData);
        } else {

            $this->attributionAdsRepository->create($attributionAdData);
        }


        $subAdData = $data[$data["ad_type"]];

        if ($isUpdate) {
            $this->updateSubAd($ad, $data["ad_type"], $subAdData);
        } else {
            $subAdData["ad_id"] = $ad->id;

            $this->createSubAd($data["ad_type"], $subAdData);
        }

        DB::commit();

        $ad->refresh();

        return $ad;
    }

    /**
     * @param Ad $ad
     * @return array
     */
    public function getAdDepartmentCodes(Ad $ad)
    {
        $departmentsCode = [];

        if (count($ad->cities)) {
            /** @var City $city */
            foreach ($ad->cities as $city) {
                if ($city->department) {
                    //dd($city);
                    $departmentsCode[] = $city->department->code;
                }
            }
        }

        if (count($ad->departments)) {
            /** @var Department $department */
            foreach ($ad->departments as $department) {
                $departmentsCode[] = $department->code;
            }
        }

        if (count($ad->regions)) {
            /** @var Region $foundRegion */
            foreach ($ad->regions as $region) {
                foreach ($region->departments as $department) {
                    $departmentsCode[] = $department->code;
                }
            }
        }
        return array_unique($departmentsCode);

//		CODE VARIATION
//		$ad = $this->wrappedObject;
//		$adDepartmentsCodes = $ad->departments->pluck('code')->toArray();
//		$adCitiesDepartmentsCodes = $ad->cities->map(function ($city) use ($adDepartmentsCodes) {
//			return $city->department->code;
//		})->toArray();
//		$adRegionsDepartmentsCodes = $ad->regions->map(function ($region) {
//			return $region->departments->pluck('code');
//		})->toArray();
//
//		return array_unique(array_merge($adCitiesDepartmentsCodes, $adDepartmentsCodes, ...$adRegionsDepartmentsCodes));



    }

    protected function updateSubAd(Ad $ad, string $adType, array $data)
    {
        if ($adType === "land_seek") {
            $subAd = $this->landSeekAdRepository->update($ad->landSeekAd, $data);
        } else if ($adType === "land_offer") {
            $subAd = $this->landOfferAdRepository->update($ad->landOfferAd, $data);
        } else if ($adType === "job_offer") {
            $subAd = $this->jobOfferAdRepository->update($ad->jobOfferAd, $data);
        } else if ($adType === "job_seek") {
            $subAd = $this->jobSeekAdRepository->update($ad->jobSeekAd, $data);
        }

        return $subAd;
    }

    protected function createSubAd(string $adType, array $data)
    {
        if ($adType === "land_seek") {
            $subAd = $this->landSeekAdRepository->create($data);
        } else if ($adType === "land_offer") {
            $subAd = $this->landOfferAdRepository->create($data);
        } else if ($adType === "job_offer") {
            $subAd = $this->jobOfferAdRepository->create($data);
        } else if ($adType === "job_seek") {
            $subAd = $this->jobSeekAdRepository->create($data);
        }

        return $subAd;
    }

    /**
     * Create the ad without requesting to publish it
     *
     * @param array $data
     * @return mixed
     * @throws \Throwable
     */
    public function store(array $data)
    {
        $isUpdate = !empty($data["id"]);

        DB::beginTransaction();

        if ($isUpdate) {
            $ad = $this->repository->update($data["id"], $data);
        } else {
            $ad = $this->repository->create($data);
        }

        $subAdData = $data[$data["ad_type"]];
        $subAdData["ad_id"] = $ad->id;

        if ($isUpdate) {
            $this->updateSubAd($ad, $data["ad_type"], $subAdData);
        } else {
            $subAdData["ad_id"] = $ad->id;

            $this->createSubAd($data["ad_type"], $subAdData);
        }

        DB::commit();

        $ad->refresh();

        return $ad;
    }

    /**
     * @param Ad $ad
     * @return string
     * @throws \Exception
     */
    public function getAdType(Ad $ad)
    {
        if ($ad->landSeekAd) {
            return 'land_seek';
        }
        if ($ad->landOfferAd) {
            return 'land_offer';
        }
        if ($ad->jobOfferAd) {
            return 'job_offer';
        }
        if ($ad->jobSeekAd) {
            return 'job_seek';
        }

        throw new \Exception("Ad type not found on id " . $ad->id);
    }

    /**
     * @param int $id
     * @return \App\Models\Ad
     */
    public function find(int $id)
    {
        $ad = $this->repository->find($id);

        return $ad;
    }

    /**
     * @return \App\Models\Ad[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function findAll()
    {
        $ads = $this->repository->all();

        return $ads;
    }

    /**
     * Find all ads and projects created by to user
     * @param $idUser
     * @return Collection
     */
    public function findAllByUser($idUser, $conditions = []): Collection
    {
        return $ads = $this->repository->allByIdUser($idUser, $conditions);
    }

    /**
     * Find all ads created by user
     * @param $idUser
     * @return Collection
     */
    public function findAllAdsByUser($idUser): Collection
    {
        $ads = $this->repository->allAdsByIdUser($idUser);

        return $ads;
    }

    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function getProductionGenres()
    {
        return $this->productionGenreRepository->all();
    }

    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function getProductionGenresFlattened()
    {
        return $this->productionGenreRepository->getFlattened();
    }

    /**
     * @param Ad $ad
     * @return void
     * @throws \Exception
     */
    public function delete(Ad $ad)
    {
        return $this->repository->destroy($ad->id);
    }

    /**
     * Show all ads ads related to supervisor
     * @param bool $toPaginate
     * @return LengthAwarePaginator|Collection
     */
    public function findAllByUserSupervisor(bool $toPaginate)
    {
        $supervisorLocationTerritoryCodes = $this->userService->getCurrentUserTerritoryDepartments();
        $ads = $this->repository->allInTerritories($supervisorLocationTerritoryCodes, $toPaginate);
        return $ads;
    }

    /**
     * Show all projects with first contact support stage  related to supervisor
     * @param bool $toPaginate
     * @return LengthAwarePaginator|Collection
     */
    public function findAllNotAssignedProjectsByUserSupervisor(bool $toPaginate)
    {
        $supervisorLocationTerritoryCodes = $this->userService->getCurrentUserTerritoryDepartments();

        $ads = $this->repository->allNotAssignedProjectsInTerritories($supervisorLocationTerritoryCodes, $toPaginate);
        return $ads;
    }

    /**
     * @param array $dates
     * @return mixed
     */
    public function findAllByUserSupervisorBetweenDates(array $dates): Collection
    {
        $supervisorLocationTerritoryCodes = $this->userService->getCurrentUserTerritoryDepartments();
        $ads = $this->repository->findAllByUserTerritoriesAndDates($supervisorLocationTerritoryCodes, $dates);
        return $ads;
    }

    /**
     * @return Collection $ads
     */
    public function findAllAdsInSupervisorTerritories(): Collection
    {
        $supervisorLocationTerritoryCodes = $this->userService->getCurrentUserTerritoryDepartments();
        $ads = $this->repository->allAdsInTerritories($supervisorLocationTerritoryCodes);
        return $ads;
    }

    /**
     * @param int $id
     * @return \App\Models\Ad
     */
    public function findWithTrashedUser(int $id)
    {
        $ad = $this->repository->findWithTrashedUser($id);

        return $ad;
    }

    /**
     * @return Collection
     */
    public function findAllValidateAdsInSupervisorTerritories(): Collection
    {
        $supervisorLocationTerritoryCodes = $this->userService->getCurrentUserTerritoryDepartments();
        $validateStatusId = AdStatus::where('id', '=', AdStatus::APPROVE_ID)->first()->id;
        $ads = $this->repository->allInTerritoriesByAdStatus($supervisorLocationTerritoryCodes, $validateStatusId);
        return $ads;
    }

    /**
     * @return Collection
     */
    public function groupAllValidatedAdsInYearByMonth(Collection $ads): Collection
    {
        $validatedAds = $ads->filter(function ($ads, $key) {
            if ($ads->attributionAd->ad_status_id === AdStatus::APPROVE_ID) {
                return $ads;
            }
        });
        $validatedAdsByMonthInYear = [];
        $listOfMonthInYear = $this->attributionAdsService->getListOfMonthInYear();
        if (!empty($validatedAds)) {
            $validatedAdsInYear = $validatedAds->filter(function ($ad, $key) {
                $date = Carbon::parse($ad->attributionAd->published_on);
                if ($date->isBetween(Carbon::now()->startOfYear(), Carbon::now()->endOfYear())) {
                    return $ad;
                }
            });
            $validatedAdsByMonthInYear = $validatedAdsInYear->mapToGroups(function ($ad, $key) {
                $date = Carbon::parse($ad->attributionAd->published_on);
                return [$date->localeMonth => $ad];
            });
        }
        return $listOfMonthInYear->merge($validatedAdsByMonthInYear);
    }

    /**
     * @return Collection
     */
    public function findAllAdsAndProjectsGroupByUserPp(): Collection
    {
        $supervisorLocationTerritoryCodes = $this->userService->getCurrentUserTerritoryDepartments();
        $users = $this->repository->allInTerritories($supervisorLocationTerritoryCodes, false)->groupBy('user_pp_id');
        return $users;
    }

    /**
     * @param Collection $ads
     * @return Collection
     */
    public function groupAdsBySupervisorDepartments(Collection $ads)
    {
        $adsPublished = $this->filterAdsByPublishedYear($ads);
        $userDepartmentsNames = auth()->user()->departments->pluck('name')->flip()->map(function ($item) {
            return collect([]);
        });

        return $adsPublishedByTerritories = $adsPublished->map(function ($item) use ($userDepartmentsNames) {
            $adsPerDepartment = $item->mapToGroups(function ($ad, $key) {
                if (!empty($ad->departments)) {
                    foreach ($ad->departments as $department) {
                        return [$department->name => $ad];
                    }
                }
                if (!empty($ad->cities)) {
                    foreach ($ad->cities as $city) {
                        return [$city->department->name => $ad];
                    }
                }
            });
            return $adsPerDepartment->union($userDepartmentsNames);
        });

    }

    /**
     * @param Collection $ads
     * @return Collection
     */
    public function filterAdsByPublishedYear(Collection $ads)
    {
        $onlyAdsPublished = $ads->filter(function ($ad, $key) {
            if (!empty($ad->attributionAd)) {
                if (!is_null($ad->attributionAd->published_on)) {
                    $date = Carbon::parse($ad->attributionAd->published_on);
                    if ($date->isBetween(Carbon::now()->startOfYear()->subYear(), Carbon::now()->endOfYear()->subYear())) {
                        return $ad;
                    }
                    if ($date->isBetween(Carbon::now()->startOfYear(), Carbon::now())) {
                        return $ad;
                    }
                }

            }
        });

        return $groupPublishedAdsByYears = $onlyAdsPublished->mapToGroups(function ($ad, $key) {
            $date = Carbon::parse($ad->attributionAd->published_on);
            return [$date->year => $ad];
        });
    }

    /**
     * @param Collection $ads
     * @return Collection
     */
    public function groupAdsBySupervisorRegions(Collection $ads)
    {
        $adsPublished = $this->filterAdsByPublishedYear($ads);
        $userRegionsNames = auth()->user()->regions->pluck('name')->flip()->map(function ($item) {
            return collect([]);
        });
        return $adsPublishedByTerritories = $adsPublished->map(function ($item) use ($userRegionsNames) {
            $adsPerRegion = $item->mapToGroups(function ($ad, $key) {
                if (!empty($ad->regions)) {
                    foreach ($ad->regions as $region) {
                        return [$region->name => $ad];
                    }
                }
                if (!empty($ad->departments)) {
                    foreach ($ad->departments as $department) {
                        return [$department->region->name => $ad];
                    }
                }
                if (!empty($ad->cities)) {
                    foreach ($ad->cities as $city) {
                        return [$city->department->region->name => $ad];
                    }
                }
            });
            return $adsPerRegion->union($userRegionsNames);
        });
    }

    /**
     * @param Collection $ads
     * @return array
     */
    public function countAdsByAdStatus(Collection $ads): array
    {
        $numberOfAdsByAdStatus = [
            AdStatus::ARCHIVED_ID => 0,
            AdStatus::REFUSE_ID => 0,
            AdStatus::PENDING_MODERATION_STATUS_ID => 0,
        ];
        foreach ($ads as $ad) {
            if (!is_null($ad->attributionAd)) {
                foreach ($numberOfAdsByAdStatus as $key => $value) {
                    if ($key === $ad->attributionAd->adStatus->id) {
                        $numberOfAdsByAdStatus[$key]++;
                    }
                }
            }
        }
        return $numberOfAdsByAdStatus;
    }

    /**
     * Ad filters for supervisor dashboard
     * @param Request $filters
     * @return LengthAwarePaginator
     */
    public function showForSupervisor(Request $request)
    {
        $toPaginate = $request->has('toPaginate') ? true : false;
        $ads = $this->filter($request, auth()->user()->role, $toPaginate);
        return $ads;
    }

    /**
     * @param Request $filters
     * @param int $roleUser
     * @param bool $toPaginate
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function filter(Request $filters, int $roleUser, bool $toPaginate)
    {
        //TODO move this method to the related repository
        //START QUERY
        $adsFiltred = (new Ad())->newQuery();

        //Remove all trashed users
        $adsFiltred->whereHas('userPp', function (Builder $query) {
            $query->whereNull('deleted_at');
        });


        if (Route::currentRouteName() === "advisor.show") {
            //Remove all support request that are not attributed to anyone by the supervisor in advisors dashboard
            $adsFiltred->whereHas('attributionAd', function (Builder $query) {
                $query->whereNotNull('user_advisor_id');
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
        $supervisorLocationTerritoryCodes = $this->userService->getCurrentUserTerritoryDepartments();
        $adsFiltred->where(function (Builder $query) use ($supervisorLocationTerritoryCodes, $roleUser) {
//			$query->whereNotNull('project_id');
            $query->whereHas('attributionAd', function (Builder $q) use ($roleUser) {
                $q->where('user_moderator_id', '=', auth()->id());
                if ($roleUser === 2) {
                    $q->orWhere('user_advisor_id', '=', auth()->id());
                } elseif ($roleUser >= 3)
                    $q->orWhere('user_supervisor_id', '=', auth()->id());
            });
            $query->orWhereHas('departments', function (Builder $query) use ($supervisorLocationTerritoryCodes) {
                $query->whereIn('code', $supervisorLocationTerritoryCodes);
            });
            $query->orWhereHas('cities', function (Builder $query) use ($supervisorLocationTerritoryCodes) {
                $query->whereIn('department_code', $supervisorLocationTerritoryCodes);
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
                ->leftJoin('projects as p', 'p.id', '=', 'ads.project_id')
                ->orderByDesc('p.created_at')
                ->join('attribution_ads as a', 'a.ad_id', '=', 'ads.id')
                ->orderByDesc('a.created_at');
        }

        $adsFiltred->with([
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
            'jobSeekAd',
			'project',
			'project.supportState',
			'project.supportStage',
			'project.projectStatus'
        ]);
        if ($toPaginate == true) {
            return $adsFiltred->paginate(15);
        } else {
            return $adsFiltred->get();
        }
    }

    public function findAllAdsNotCompleteAndPublishedSince(Carbon $date): Collection
    {
        $adsPublishedSinceDays = $this->repository->findAllByPublishedOnSince($date);

        return $adsPublishedSinceDays->mapWithKeys(function ($ad) {
            if (is_null($ad['about_content']) || is_null($ad['about_project_content']) || isset($ad['documents'])) {
                return [$ad['id'] => $ad];
            }
            return [];
        })->filter();
    }

    /**
     * @param Carbon $date
     * @return Ad[]|Collection
     */
    public function findAllNotAttributedSince(Carbon $date): Collection
    {
        $adsNotAttributed = $this->repository->findAllNotAttributedSince($date);

        return $adsNotAttributed;
    }

    public function getPublishedAdsCountByRegionId($selectedAdType)
    {
        $adsCountByRegionId = [];

        foreach ($this->repository->findAllPublishedWithLocations($selectedAdType) as $ad) {
            $regionIds = $this->getAdRegionIds($ad);

            foreach ($regionIds as $regionId) {
                if (!isset($adsCountByRegionId[$regionId])) {
                    $adsCountByRegionId[$regionId] = 0;
                }
                $adsCountByRegionId[$regionId]++;
            }
        }
        return $adsCountByRegionId;
    }

    /**
     * @param Ad $ad
     * @return array
     */
    public function getAdRegionIds(Ad $ad)
    {
        $regionIds = [];

        if (count($ad->cities)) {
            /** @var City $city */
            foreach ($ad->cities as $city) {
                if ($city->department && $city->department->region) {
                    $regionIds[] = $city->department->region->id;
                }
            }
        }

        if (count($ad->departments)) {
            /** @var Department $department */
            foreach ($ad->departments as $department) {
                if ($department->region) {
                    $regionIds[] = $department->region->id;
                }
            }
        }

        if (count($ad->regions)) {
            /** @var Region $foundRegion */
            foreach ($ad->regions as $region) {
                $regionIds[] = $region->id;
            }
        }

        return array_unique($regionIds);
    }

    /**
     * @return int
     */
    public function getPublishedAdsCount()
    {
        return $this->repository->countAllPublished();
    }

    /**
     * @param Ad $ad
     * @return User[]|\Illuminate\Database\Eloquent\Collection|Collection
     */
    public function getAdSupervisors(Ad $ad)
    {
        $departmentCodes = $this->getAdDepartmentCodes($ad);

        return $this->userService->findByRoleAndDepartments(3, $departmentCodes);
    }

    public function getUserPublishedAdsCount(User $user)
    {
        return $user->ads()->whereHas('attributionAd', function (Builder $builder) {
            $builder
                ->whereNotNull('published_on')
                ->where('ad_status_id', AdStatus::APPROVE_ID);
        })->count();
    }

    /**
     * @param Carbon $date
     * @return Ad[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findAdsPublishedSince(Carbon $date)
    {
        return $this->repository->findAllByPublishedOnSince($date);
    }

    public function findAttributedAndNotDraftedByUserId(int $id)
    {
        return $this->repository->findAttributedAndNotDraftedByUserId($id);
    }
}