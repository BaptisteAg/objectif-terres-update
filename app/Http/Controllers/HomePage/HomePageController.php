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
		if (!auth()->user() && config('app.is_coming_soon')) {
			return view('pages.coming_soon');
		}

		//TODO get the last ads with  : $lastAdsAdded = AttributionAdEvents::orderBy('id', 'desc')->take(2)->get();

		$ads = Ad::whereHas('attributionAd', function (Builder $query) {
			$query->where('ad_status_id', '=', AdStatus::APPROVE_ID);
		})->where('is_draft', '=', 0)->take(4)->orderBy('created_at', 'desc')->get()->shuffle();

		$adsPartner = Ad::where('is_partner', 1)->whereHas('attributionAd', function (Builder $query) {
			$query->where('ad_status_id', '=', AdStatus::APPROVE_ID);
		})->where('is_draft', '=', 0)->take(4)->orderBy('created_at', 'desc')->get();

        //TODO, in the V2, inject faq section content into the the template
        //$cmsFaq = CmsFaq::where('page_name', '=', Route::currentRouteName())->get();
		$rssNews = $rssService->getTdlNews();
		return view('pages.homepage', compact('ads', 'adsPartner', 'rssNews'));
	}
}
