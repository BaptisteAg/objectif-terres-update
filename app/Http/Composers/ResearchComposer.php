<?php

namespace App\Http\Composers;

use App\Models\Region;
use Illuminate\View\View;

class ResearchComposer
{

    public function compose(View $view)
    {

        $regions = Region::all();
        $regions_array = [];
        foreach ($regions as $region) {
            $regions_array[$region->id] = $region->name;
        }
        $view->with('regions_array', $regions_array);
    }
}
