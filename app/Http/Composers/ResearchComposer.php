<?php

namespace App\Http\Composers;

use App\Models\BioCertification;
use App\Models\Department;
use App\Models\jobOfferType;
use App\Models\ProductionGenre;
use App\Models\Region;
use Illuminate\View\View;

class ResearchComposer
{

    public function compose(View $view)
    {
        $regions = Region::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
//        $cities = City::orderBy('name')->get();

        $jobOfferTypes = jobOfferType::orderBy('name')->get();
//        $surfaces = SurfaceRange::all()->pluck('surface');
        $productionGenres = ProductionGenre::orderBy('name')->get();
        $bioCertifications = BioCertification::orderBy('name')->get();

        $view->with(compact('regions','departments', 'jobOfferTypes', 'productionGenres', 'bioCertifications'));
    }
}