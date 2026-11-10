<?php

namespace App\Http\Composers;

use App\Models\CmsCommonContent;
use Illuminate\View\View;

class InfoBanner
{
    public function compose(View $view)
    {
        $infoBanner = CmsCommonContent::where('slug', 'like', 'info-banner')->value('content');
        $view->with(compact('infoBanner'));
    }
}
