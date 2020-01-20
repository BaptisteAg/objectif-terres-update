<?php

namespace App\Http\Composers;

use App\Models\Region;
use Illuminate\View\View;

class ResearchComposer
{

    public function compose(View $view)
    {
        $regions = Region::orderBy('name')->get();
        $view->with('regions', $regions);
    }
}
