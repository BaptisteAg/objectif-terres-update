<?php

namespace App\Http\Composers;

use App\Models\BioCertification;
use App\Models\Department;
use App\Models\EducationLevel;
use App\Models\InstallationType;
use App\Models\JobOfferType;
use App\Models\OfferGenre;
use App\Models\Region;
use App\Services\Ads\AdService;
use Illuminate\View\View;

class ResearchComposer
{
    public function __construct(private AdService $adService) {}

    public function compose(View $view)
    {
        //        Gerer coter front
        /*        $regionsWithAll = Region::orderBy('name')->get()->prepend(
                    (object)[
                        'id' => -1,
                        'name' => 'Toutes les régions'
                    ]
                );*/

        $regionsWithAll = Region::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();

        $jobOfferTypes = JobOfferType::orderBy('name')->get();
        $productionGenres = $this->adService->getProductionGenresFlattened();
        $bioCertifications = BioCertification::orderBy('name')->get();
        $offerGenres = OfferGenre::where('id', '!=', OfferGenre::ID_LEG_OU_DONATION)->orderBy('name')->get();

        $installationTypes = InstallationType::all();
        $educationLevels = EducationLevel::all();

        $view->with(compact('regionsWithAll', 'departments', 'jobOfferTypes', 'productionGenres', 'bioCertifications', 'offerGenres', 'installationTypes', 'educationLevels', 'jobOfferTypes'));
    }
}
