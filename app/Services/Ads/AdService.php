<?php namespace App\Services\Ads;

use App\Exceptions\AttributionAdException;
use App\Jobs\NotifySupportRequestAttribution;
use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\City;
use App\Models\CmsPage;
use App\Models\Department;
use App\Models\OfferGenre;
use App\Models\ProjectDataKey;
use App\Models\ProjectStatus;
use App\Models\Region;
use App\Models\SupportStage;
use App\Models\SupportState;
use App\Models\Territory;
use App\Models\User;
use App\Notifications\BasicNotification;
use App\Notifications\NewAdToModerateNotification;
use App\Notifications\NewSupportRequestNotification;
use App\Notifications\PendingModerationNotification;
use App\Notifications\SupportRequestAttributionNotification;
use App\Notifications\SupportRequestTerritoryNotification;
use App\Repositories\AdNotes\AdNotesRepository;
use App\Repositories\Ads\AdRepository;
use App\Repositories\Ads\AssociateOfferAdRepository;
use App\Repositories\Ads\JobOfferAdRepository;
use App\Repositories\Ads\JobSeekAdRepository;
use App\Repositories\Ads\LandOfferAdRepository;
use App\Repositories\Ads\LandSeekAdRepository;
use App\Repositories\Ads\AssociateSeekAdRepository;
use App\Repositories\Ads\ProductionGenreRepository;
use App\Repositories\AttributionAds\AttributionAdsRepository;
use App\Repositories\Projects\ProjectsRepository;
use App\Services\Users\UserService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Throwable;

/**
 * Class AdService
 * @package App\Services\Ads
 */
class  AdService
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
     * @var AssociateSeekAdRepository
     */
    protected $associateSeekAdRepository;
    /**
     * @var AssociateOfferAdRepository
     */
    protected $associateOfferAdRepository;
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
    protected $adNotesRepository;


    /**
     * AdService constructor.
     * @param AdRepository $repository
     * @param AttributionAdsRepository $attributionAdsRepository
     * @param LandSeekAdRepository $landSeekAdRepository
     * @param LandOfferAdRepository $landOfferAdRepository
     * @param AssociateSeekAdRepository $associateSeekAdRepository
     * @param JobOfferAdRepository $jobOfferAdRepository
     * @param JobSeekAdRepository $jobSeekAdRepository
     * @param ProductionGenreRepository $productionGenreRepository
     * @param ProjectsRepository $projectRepository
     * @param UserService $userService
     * @param NotifySupportRequestAttribution $notificationSupportRequestAttribution
     */
    public function __construct(
        AdRepository              $repository,
        AttributionAdsRepository  $attributionAdsRepository,
        LandSeekAdRepository      $landSeekAdRepository,
        LandOfferAdRepository     $landOfferAdRepository,
        AssociateSeekAdRepository $associateSeekAdRepository,
        AssociateOfferAdRepository $associateOfferAdRepository,
        JobOfferAdRepository      $jobOfferAdRepository,
        JobSeekAdRepository       $jobSeekAdRepository,
        ProductionGenreRepository $productionGenreRepository,
        ProjectsRepository        $projectRepository,
        UserService               $userService,
        AdNotesRepository         $adNotesRepository,
    )
    {
        $this->repository = $repository;
        $this->attributionAdsRepository = $attributionAdsRepository;
        $this->landSeekAdRepository = $landSeekAdRepository;
        $this->landOfferAdRepository = $landOfferAdRepository;
        $this->jobOfferAdRepository = $jobOfferAdRepository;
        $this->jobSeekAdRepository = $jobSeekAdRepository;
        $this->associateSeekAdRepository = $associateSeekAdRepository;
        $this->associateOfferAdRepository = $associateOfferAdRepository;
        $this->productionGenreRepository = $productionGenreRepository;
        $this->userService = $userService;
        $this->projectRepository = $projectRepository;
        $this->adNotesRepository = $adNotesRepository;
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
     * @return Ad
     * @throws \Throwable
     */
    public function requestPublishing(Ad $ad)
    {
        DB::beginTransaction();


        $attributionAdData = [];

        //$adDepartmentCodes = $this->getAdDepartmentCodesFromZones($ad);
        $adDepartmentCodes = [$ad->main_department->code];
        $availableModerators = $this->userService->findByRolesAndDepartments([1], $adDepartmentCodes);
        $availableSupervisors = $this->userService->findByRolesAndDepartments([3], $adDepartmentCodes);
        $availableUserWithPermission = $this->userService->findOneByUserPermissionAndDepartments(1, $adDepartmentCodes);

        if ($availableModerators->isEmpty() && $availableSupervisors->isEmpty() && empty($availableUserWithPermission)) {
            throw new AttributionAdException("Aucun modérateur n'a été trouvé dans votre région. Veuillez sauvegarder votre annonce et nous contacter.");
        }
        // If ad was attributed before, we'll get the same moderator if available
        if ($ad->attributionAd && $ad->attributionAd->userModerator &&
            $availableModerators->keyBy("id")->find($ad->attributionAd->user_moderator_id)) {
            $moderator = $ad->attributionAd->userModerator;
        } else {
            if ($availableModerators->count() >= 1) {
                /** @var User $moderator */
                $moderator = $availableModerators->random();
            }
            else if($availableSupervisors->count() >= 1) {
                /** @var User $moderator */
                $moderator = $availableSupervisors->random();
            }
            else if (!empty($availableUserWithPermission)) {
                $moderator = $availableUserWithPermission;
            }
        }
        $attributionAdData['ad_status_id'] = AdStatus::PENDING_MODERATION_STATUS_ID;
        $attributionAdData['user_moderator_id'] = $moderator->id;

        $attributionAdData['ad_id'] = $ad->id;

        if ($ad->attributionAd && !in_array($ad->attributionAd->adStatus->id, [AdStatus::REFUSE_ID, AdStatus::ARCHIVED_ID])) {
            $this->attributionAdsRepository->update($ad->attributionAd->id, $attributionAdData);
        } else {
            $this->attributionAdsRepository->create($attributionAdData);
        }

        DB::commit();

        $ad->refresh();

        $ad->attributionAd->userModerator->notify(new NewAdToModerateNotification($ad, auth()->user()));
        $ad->userPp->notify(new PendingModerationNotification($ad));

        return $ad;
    }

    /**
     * @param array $data
     * @throws \Exception
     * @throws Throwable
     */
    public function importAd(array $data, $userId): Ad
    {
        DB::beginTransaction();

        $ad = $this->repository->createForUser($data, $userId);

        if (!$data["is_draft"]) {
            $adDepartmentCodes = $this->getAdDepartmentCodesFromZones($ad);

            $availableModerators = $this->userService->findByRolesAndDepartments([1], $adDepartmentCodes);
            $availableUserWithPermission = $this->userService->findOneByUserPermissionAndDepartments(1, $adDepartmentCodes);

            if ($availableModerators->isEmpty() && empty($availableUserWithPermission)) {
                throw new AttributionAdException("Aucun modérateur n'a été trouvé dans les départements " . implode(", ", $adDepartmentCodes));
            }

            // Modérateur
            if ($availableModerators->count() >= 1) {
                /** @var User $moderator */
                $moderator = $availableModerators->random();
            } // Sinon utilisateur random avec permissions spéciales
            else if (!empty($availableUserWithPermission)) {
                $moderator = $availableUserWithPermission;
            }

            // Annonce déjà approuvée sur SPIP
            $attributionAdData['ad_id'] = $ad->id;
            $attributionAdData['user_moderator_id'] = $moderator->id;
            $attributionAdData['ad_status_id'] = AdStatus::APPROVE_ID;
            $attributionAdData['published_on'] = $data["created_at"];

            $this->attributionAdsRepository->create($attributionAdData);
        }

        if (isset($data[$data["ad_type"]])) {
            $subAdData = $data[$data["ad_type"]];
            $subAdData["ad_id"] = $ad->id;
            $this->createSubAd($data["ad_type"], $subAdData);
        }

        DB::commit();
        return $ad;
    }

    /**
     * @param Ad $ad
     * @param array $data
     * @return Ad
     * @throws \Throwable
     */
    public function update($id, array $data)
    {
        $ad = $this->repository->update($id, $data);

        $subAdData = $data[$data["ad_type"]];
        $this->updateSubAd($ad, $data["ad_type"], $subAdData);

        return $ad;
    }


    /**
     * @param Ad $ad
     */
    public function notifyAdvisorOfSupportRequestTerritoryChange(Ad $ad, User $advisor)
    {
        $advisor->notify(new BasicNotification([
            'subject' => "Le territoire d'une demande d'accompagnement a été modifié",
            'message' => "La demande d'accompagnement ayant pour titre '" . $ad->title .
                "' et pour porteur de projet " . $ad->userPp->first_name . " " . $ad->userPp->name . "
                   			a été modifiée et ne vous est désormais plus attribuée."
        ]));
    }

    /**
     * @param Ad $ad
     */
    public function handleSupportRequestAttributionNotifications(Ad $ad)
    {
        if ($ad->attributionAd->userAdvisor) {
            $ad->attributionAd->userAdvisor->notify(new SupportRequestAttributionNotification($ad));
        } else {
            // send a notification to each related supervisor
            foreach ($this->getAdSupervisors($ad) as $supervisor) {
                $supervisor->notify(new NewSupportRequestNotification($ad));
            }
        }
        $supportRequestTerritoryModalityContent = CmsPage::where('slug', '=', 'etre-accompagne-text-du-territoire-numero-' . $ad->supportRequestTerritoryId->id)->first()->content;

        $ad->userPp->notify(new SupportRequestTerritoryNotification([
            'subject' => "Nous avons bien reçu votre demande d’accompagnement",
            'ad_title' => $ad->title,
            'supportRequest_name' => $ad->supportRequestTerritoryId->name,
            'supportRequest_content' => $supportRequestTerritoryModalityContent,
            'action' => ["Voir mon projet", route('support-request.show')]
        ]));
    }

    /**
     * @param Ad $ad
     * @return array
     */
    public function getAdDepartmentCodesFromSupportRequestTerritoryId(Ad $ad)
    {
        $departmentsCode = [];

        $territory = Territory::findOrFail($ad->support_request_territory_id);

        foreach ($territory->departments as $department) {
            $departmentsCode[] = $department->code;
        }

        return $departmentsCode;
    }

    /**
     * @param Ad $ad
     * @return array
     */
    public function getAdDepartmentCodesFromZones(Ad $ad): array
    {
        $departmentsCode = [];

        if (count($ad->cities)) {
            foreach ($ad->cities as $city) {
                if ($city->department) {
                    //dd($city);
                    $departmentsCode[] = $city->department->code;
                }
            }
        }

        if (count($ad->departments)) {
            foreach ($ad->departments as $department) {
                $departmentsCode[] = $department->code;
            }
        }

        return array_unique($departmentsCode);
    }

    /**
     * @param Ad $ad
     * @param string $adType
     * @param array $data
     * @return \App\Models\JobOfferAd|\App\Models\JobSeekAd|\App\Models\LandOfferAd|\App\Models\LandSeekAd
     */
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
        } else if ($adType === "associate_seek") {
            $subAd = $this->associateSeekAdRepository->update($ad->associateSeekAd, $data);
        } else if ($adType === "associate_offer") {
            $subAd = $this->associateOfferAdRepository->update($ad->associateOfferAd, $data);
        }

        return $subAd;
    }

    /**
     * @throws \Exception
     */
    protected function createSubAd(string $adType, array $data): \App\Models\AssociateOfferAd|\App\Models\LandSeekAd|\App\Models\JobSeekAd|\App\Models\LandOfferAd|\App\Models\AssociateSeekAd|\App\Models\JobOfferAd
    {
        if ($adType === "land_seek") {
            $subAd = $this->landSeekAdRepository->create($data);
        } else if ($adType === "land_offer") {
            $subAd = $this->landOfferAdRepository->create($data);
        } else if ($adType === "job_offer") {
            $subAd = $this->jobOfferAdRepository->create($data);
        } else if ($adType === "job_seek") {
            $subAd = $this->jobSeekAdRepository->create($data);
        } else if ($adType === "associate_seek") {
            $subAd = $this->associateSeekAdRepository->create($data);
        } else if ($adType === "associate_offer") {
            $subAd = $this->associateOfferAdRepository->create($data);
        } else {
            throw new \Exception("Ad type not found");
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

        if (isset($data[$data["ad_type"]])) {
            $subAdData = $data[$data["ad_type"]];
            $subAdData["ad_id"] = $ad->id;
            $this->createSubAd($data["ad_type"], $subAdData);
        }

        $subAdData = $data[$data["ad_type"]];
        $subAdData["ad_id"] = $ad->id;

        if (isset($subAdData["offer_genres"])) {
            if (!in_array(OfferGenre::ID_VENTE, $subAdData["offer_genres"], true)) {
                $subAdData["price"] = null;
            }
            if (!in_array(OfferGenre::ID_LOCATION, $subAdData["offer_genres"], true)) {
                $subAdData["rent_price"] = null;
            }
        }

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
     * @throws \Exception
     */
    public function getAdType(Ad $ad): string
    {
        return match($ad->type) {
            'landSeekAd' => 'land_seek',
            'landOfferAd' => 'land_offer',
            'jobOfferAd' => 'job_offer',
            'jobSeekAd' => 'job_seek',
            'associateSeekAd' => 'associate_seek',
            'associateOfferAd' => 'associate_offer',
            default => throw new \Exception("Ad type not found on id " . $ad->id),
        };
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
     * @param Ad $ad
     * @return void
     * @throws \Exception
     */
    public function archive(Ad $ad)
    {
        return $this->repository->archive($ad->id);
    }

    /**
     * Show all ads ads related to supervisor
     * @param bool $toPaginate
     * @return LengthAwarePaginator|Collection
     */
    public function findAllByUserSupervisor(bool $toPaginate)
    {
        $supervisorLocationTerritoryCodes = $this->userService->getCurrentUserTerritoryDepartments();
        $supervisorLocationTerritoryIds = $this->userService->getCurrentUserTerritoryIds();
        $ads = $this->repository->allInTerritories($supervisorLocationTerritoryCodes, $supervisorLocationTerritoryIds, $toPaginate);
        return $ads;
    }

    /**
     * Show all projects with first contact support stage  related to supervisor
     * @param bool $toPaginate
     * @return LengthAwarePaginator|Collection
     */
    public function findAllNotAssignedProjectsByUserSupervisor(bool $toPaginate)
    {
        $supervisorLocationTerritoryIds = $this->userService->getCurrentUserTerritoryIds();
        $supervisorLocationTerritoryCodes = $this->userService->getCurrentUserTerritoryDepartments();
        $ads = $this->repository->allNotAssignedProjectsInTerritories($supervisorLocationTerritoryIds, $supervisorLocationTerritoryCodes, $toPaginate);
        return $ads;
    }

    /**
     * @param array $dates
     * @return mixed
     */
    public function findAllByUserSupervisorBetweenDates(array $dates): Collection
    {
        $supervisorLocationTerritoryCodes = $this->userService->getCurrentUserTerritoryDepartments();
        $supervisorLocationTerritoryIds = $this->userService->getCurrentUserTerritoryIds();
        $ads = $this->repository->findAllByUserTerritoriesAndDates($supervisorLocationTerritoryCodes, $supervisorLocationTerritoryIds, $dates);
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
     * @param Collection $ads
     * @return Collection
     */
    public function groupAllValidatedAdsInYearByMonth(Collection $ads): Collection
    {
        $validatedAds = $ads->filter(function ($ad, $key) {
            if (isset($ad->attributionAd)) {
                if ($ad->attributionAd->ad_status_id === AdStatus::APPROVE_ID) {
                    return $ad;
                }
            }
        });
        $validatedAdsByMonthInYear = [];
        $listOfMonthInYear = $this->getListOfMonthInYear();
        if (!empty($validatedAds)) {
            $validatedAdsInYear = $validatedAds->filter(function ($ad, $key) {
                $date = Carbon::parse($ad->attributionAd->published_on);
                if ($date->isBetween(Carbon::now()->startOfYear()->subYear(), Carbon::now()->endOfYear()->subYear())) {
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
     * TODO refacto
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

    /**
     * @return Collection
     */
    public function findAllAdsAndProjectsGroupByUserPp(): Collection
    {
        $supervisorLocationTerritoryCodes = $this->userService->getCurrentUserTerritoryDepartments();
        $supervisorLocationTerritoryRegionId = $this->userService->getCurrentUserTerritoryIds();
        $users = $this->repository->allInTerritories($supervisorLocationTerritoryCodes, $supervisorLocationTerritoryRegionId, false)->groupBy('user_pp_id');
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
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function showForSupervisor(Request $request)
    {
        $toPaginate = $request->get('toPaginate') === "true" || $request->get('toPaginate') === null ? true : false;
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
        $userTerritories = $this->userService->getCurrentUserTerritoryDepartments();
        $userTerritoryIds = $this->userService->getCurrentUserTerritoryIds();
        return $this->repository->filterAds($filters, $roleUser, $userTerritories, $userTerritoryIds, $toPaginate);
    }

    /**
     * @param Carbon $date
     * @return Collection
     */
    public function findAllAdsNotCompleteAndPublishedSince(Carbon $date): Collection
    {
        $adsPublishedSinceDays = $this->repository->findAllByPublishedOlderThan($date);

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

    /**
     * @param $selectedAdType
     * @return array
     */
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
     * @param $selectedAdType
     * @param $regionId
     * @return array
     */
    public function getPublishedAdsCountByDepartmentId($selectedAdType, $regionId)
    {
        $adsCountByDepartmentId = [];

        $regionCode = Region::find($regionId)?->code;
        $regionDepartmentIds = Department::where('region_code', $regionCode)->pluck('id');

        foreach ($this->repository->findAllPublishedInRegionWithLocations($selectedAdType, $regionCode) as $ad) {
            $departmentIds = array_intersect($this->getAdDepartmentIds($ad), $regionDepartmentIds->toArray());

            foreach ($departmentIds as $departmentId) {
                if (!isset($adsCountByDepartmentId[$departmentId])) {
                    $adsCountByDepartmentId[$departmentId] = 0;
                }
                $adsCountByDepartmentId[$departmentId]++;
            }
        }

        return $adsCountByDepartmentId;
    }


    public function getAdRegions(Ad $ad)
    {
        $regions = collect();

        if (count($ad->cities)) {
            /** @var City $city */
            foreach ($ad->cities as $city) {
                if ($city->department && $city->department->region) {
                    $regions[] = $city->department->region;
                }
            }
        }

        if (count($ad->departments)) {
            /** @var Department $department */
            foreach ($ad->departments as $department) {
                if ($department->region) {
                    $regions[] = $department->region;
                }
            }
        }

        if (count($ad->regions)) {
            /** @var Region $foundRegion */
            foreach ($ad->regions as $region) {
                $regions[] = $region;
            }
        }

        return $regions->unique(function (Region $region) {
            return $region->id;
        });
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
     * @param Ad $ad
     * @return array
     */
    public function getAdDepartmentIds(Ad $ad)
    {
        $departmentIds = [];

        if (count($ad->cities)) {
            foreach ($ad->cities as $city) {
                if ($city->department) {
                    $departmentIds[] = $city->department->id;
                }
            }
        }

        if (count($ad->departments)) {
            foreach ($ad->departments as $department) {
                $departmentIds[] = $department->id;
            }
        }

        return array_unique($departmentIds);
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
        if (isset($ad->support_request_territory_id)) {
            return $this->userService->findByRolesAndTerritory([3], [$ad->support_request_territory_id]);
        }
        $departmentCodes = $this->getAdDepartmentCodesFromZones($ad);
        return $this->userService->findByRolesAndDepartments([3], $departmentCodes);
    }

    /**
     * @param User $user
     * @return int
     */
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
        return $this->repository->findAllByPublishedOlderThan($date);
    }

    /**
     * @param int $id
     * @return Ad[]|Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findAttributedAndNotDraftedByUserId(int $id)
    {
        return $this->repository->findAttributedAndNotDraftedByUserId($id);
    }

    /**
     * @param int $id
     * @return Ad[]|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|Collection
     */
    public function findAdsAttributedAndNotDraftedByUserId(int $id)
    {
        return $this->repository->findAdsAttributedAndNotDraftedByUserId($id);
    }

    public function updateAdPartnerStatus(Ad $ad, array $data)
    {
        try {
            $this->repository->update($ad, $data);
        } catch (\Throwable $e) {
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * @param int $adId
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function allPublicNotesWithProjectDatKeysByAdId(int $adId): Collection
    {
        $notes = $this->adNotesRepository->findAllNotesWithPublicProjectDatKeysByAdId($adId);
        return $notes;
    }


    /**
     * @param Request $request
     * @throws Throwable
     */
    public function updateProjectDataKeysValues(Request $request)
    {

        $requestProjectDataKeyValues = array_filter($request->input('project_data_key'));

        $previousValues = $this->adNotesRepository->findAllNotesWithPublicProjectDatKeysByAdId($request->input('ad_id'));

        $previousValues->filter(function ($note) use ($request, &$requestProjectDataKeyValues) {
            if (array_key_exists($note->project_data_key_id, $requestProjectDataKeyValues)) {
                if ($note->value != $requestProjectDataKeyValues[$note->project_data_key_id]) {
                    $note->value = $requestProjectDataKeyValues[$note->project_data_key_id];
                    $note->user_id = $request->input('user_id');
                    $note->save();

                    $projectDataKey = ProjectDataKey::whereId($note->project_data_key_id)->with('projectDataValues')->first();

                    if ($projectDataKey->projectDataValues->count() > 0) {
                        $projectDataKey->projectDataValues->filter(function ($projectDataValue) use ($note, $requestProjectDataKeyValues) {
                            if ($projectDataValue->value === $requestProjectDataKeyValues[$note->project_data_key_id]) {
                                $note->projectDataValue()->associate($projectDataValue->id);
                                $note->save();
                            }
                        });
                    }
                }
                unset($requestProjectDataKeyValues[$note->project_data_key_id]);
            }
        });
        if (count($requestProjectDataKeyValues) > 0) {
            foreach ($requestProjectDataKeyValues as $key => $value) {
                $data = Arr::only($request->input(), [
                    "ad_id",
                    "user_id"
                ]);
                $data['value'] = $value;
                $data['project_data_key_id'] = $key;
                $this->adNotesRepository->create($data);
            }
        }
    }


    /**
     * Get ads by date range.
     *
     * @param string $from
     * @param string $to
     * @return \Illuminate\Database\Eloquent\Collection|Ad[]
     */
    public function getAdsByDate(string $from, string $to): \Illuminate\Database\Eloquent\Collection|array
    {
        $fromDate = Carbon::createFromFormat('Y-m-d', $from);
        $toDate = Carbon::createFromFormat('Y-m-d', $to);

        return Ad::withTrashed()
            ->where('is_draft', false)
            ->whereHas('attributionAd')
            ->whereHas('userPp')
            ->where(fn($q) => $q
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->orWhereBetween('updated_at', [$fromDate, $toDate])
                ->orWhereBetween('deleted_at', [$fromDate, $toDate])
            )
            ->limit(3)
            ->get();
    }
}
