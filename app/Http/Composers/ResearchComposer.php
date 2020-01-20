<?php

namespace App\Http\Composers;

use App\Models\City;
use App\Models\Department;
use App\Models\JobStatus;
use App\Models\ProjectStatus;
use App\Models\Region;
use App\Models\SurfaceRange;
use Illuminate\View\View;

class ResearchComposer
{

    public function compose(View $view)
    {
        $regions = Region::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
//        $cities = City::orderBy('name')->get();

        $jobStatuses = JobStatus::orderBy('name')->get();
        $surfaces = SurfaceRange::all();

        $view->with(compact('regions','departments', 'jobStatuses', 'surfaces'));
    }
}
