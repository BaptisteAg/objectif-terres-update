<?php

namespace App\Http\Controllers\HomePage;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\AdStatus;
use App\Services\Ads\AdService;
use App\Services\Rss\RssService;
use Illuminate\Database\Eloquent\Builder;

class HomePageController extends Controller
{
    /**
     * @var AdService
     */
    protected $adService;

    public function __construct(AdService $adService)
    {
        $this->adService = $adService;

    }

    public function show(AdService $adService, RssService $rssService)
    {
        if (! auth()->user() && config('app.is_coming_soon')) {
            return view('pages.coming_soon');
        }

        $adsQuery = Ad::query()
            ->whereHas('attributionAd', function (Builder $query) {
                $query->where('ad_status_id', '=', AdStatus::APPROVE_ID)
                    ->whereNull('archived_at');
            })
            ->whereNull('deleted_at')
            ->where('is_draft', '=', 0)
            ->take(4)
            ->orderBy('created_at', 'desc');

        $ads = $adsQuery->get();
        $adsPartner = $adsQuery->where('is_partner', 1)->get();

        // $rssNews = $rssService->getTdlNews();
        return view('pages.homepage', compact('ads', 'adsPartner'));
    }
}
