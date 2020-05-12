<?php

namespace App\Http\Controllers\Ads;

use App\Http\Controllers\Controller;
use App\Models\AgriculturalActivity;
use App\Models\BioCertification;
use App\Models\BuildingType;
use App\Models\EducationLevel;
use App\Models\InstallationType;
use App\Models\JobOfferType;
use App\Models\OfferGenre;
use App\Models\Requirement;
use App\Models\SurfaceRange;
use App\Repositories\FavoriteAds\FavoriteAdRepository;
use App\Services\Ads\AdService;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;


abstract class BaseController extends Controller
{
    /** @var AdService */
    protected $adService;
    /** @var ThreadService  */
    protected $threadService;
    /** @var FavoriteAdRepository  */
    protected $favoriteAdRepository;
    /** @var UserService  */
    protected $userService;

    public function __construct(AdService $adService, ThreadService $threadService, FavoriteAdRepository $favoriteAdRepository, UserService $userService)
    {
        $this->adService = $adService;
        $this->threadService = $threadService;
        $this->favoriteAdRepository = $favoriteAdRepository;
        $this->userService = $userService;
    }

    /**
     * Returns all the vars needed to display an ad creation form
     *
     * @return array
     */
    protected function getCreateFormVars() : array
    {
        $surfaceRanges = SurfaceRange::all();
        $installationTypes = InstallationType::all();
        $bioCertifications = BioCertification::all();
        $jobOfferTypes = JobOfferType::all();
        $offerGenres = OfferGenre::all();
        $agriculturalActivities = AgriculturalActivity::all();
        $educationLevels = EducationLevel::all();
        $buildingTypes = BuildingType::all();
        $requirements = Requirement::all();
        $productionGenres = $this->adService->getProductionGenresFlattened();
        $productionGenresWithOther = clone $this->adService->getProductionGenresFlattened()
            ->concat([[
                'id' => 'other',
                'name' => 'Autre',
                'children' => []
            ]]);

        return compact(
            'installationTypes',
            'surfaceRanges',
            'bioCertifications',
            'jobOfferTypes',
            'offerGenres',
            'educationLevels',
            'productionGenres',
            'productionGenresWithOther',
            'agriculturalActivities',
            'buildingTypes',
            'requirements'
        );
    }
}
