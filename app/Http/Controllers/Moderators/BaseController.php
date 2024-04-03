<?php

namespace App\Http\Controllers\Moderators;

use App\Models\AdStatus;
use App\Models\BioCertification;
use App\Models\City;
use App\Models\Department;
use App\Models\JobOfferType;
use App\Models\ProductionGenre;
use App\Models\Region;
use App\Services\AttributionAds\AttributionAdsService;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;

abstract class BaseController
{
    protected $service;
    protected $threadService;
    protected $userService;
    protected $adTypes;
    protected $adTypesFaIcons;


    public function __construct(AttributionAdsService $attributionAdsService, ThreadService $threadService, UserService $userService)
    {
        $this->service = $attributionAdsService;
        $this->threadService = $threadService;
        $this->userService = $userService;
        $this->adTypes = [
            ['name' => 'Offre foncière', 'value' => 'landOfferAd'],
            ['name' => 'Recherche foncière', 'value' => 'landSeekAd'],
            ['name' => 'Offre d\'emploi', 'value' => 'jobOfferAd'],
            ['name' => 'Recherche d\'emploi', 'value' => 'jobSeekAd'],
            ['name' => 'Associé sur une ferme', 'value' => 'associateOfferAd'],
            ['name' => 'Associé pour projet d\'installation', 'value' => 'associateSeekAd'],
        ];
        $this->adTypesFaIcons = ["fa-home", "fa-home", "fa-universal-access", "fa-universal-access", "fa-user-tie", "fa-user-tie"];
    }


    /**
     * Get all vars for moderator dashboard
     * @return array
     */
    protected function getModeratorDashboardVars(): array
    {
        $cities = City::all();
        $departments = Department::all();
        $regions = Region::all();
        $adStatuses = AdStatus::all();
        $productionGenres = ProductionGenre::all();
        $jobOfferTypes = JobOfferType::all();
        $bioCertifications = BioCertification::all();
        $adTypes = $this->adTypes;
        $adTypesFaIcons = $this->adTypesFaIcons;
        $numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();
        $numberOfAdsToModerate = $this->service->countAllAdsToModerateForLoggedModerator();


        return compact(
            'cities',
            'departments',
            'regions',
            'adStatuses',
            'productionGenres',
            'jobOfferTypes',
            'adTypes',
            'adTypesFaIcons',
            'numberOfAdsToModerate',
            'numberOfUnreadMessages',
            'bioCertifications'
        );
    }

}
