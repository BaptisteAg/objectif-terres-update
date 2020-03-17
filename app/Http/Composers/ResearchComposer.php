<?php

namespace App\Http\Composers;

use App\Models\BioCertification;
use App\Models\Department;
use App\Models\JobOfferType;
use App\Models\OfferGenre;
use App\Models\ProductionGenre;
use App\Models\Region;
use Illuminate\View\View;

class ResearchComposer
{

    public function compose(View $view)
    {
        $regions = Region::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();


        $jobOfferTypes = JobOfferType::orderBy('name')->get();
        $productionGenres = ProductionGenre::orderBy('name')->get();
        $bioCertifications = BioCertification::orderBy('name')->get();
		$offerGenres = OfferGenre::orderBy('name')->get();

        $view->with(compact('regions','departments', 'jobOfferTypes', 'productionGenres', 'bioCertifications', 'offerGenres'));
    }
}