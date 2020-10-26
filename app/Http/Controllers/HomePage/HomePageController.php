<?php

namespace App\Http\Controllers\HomePage;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\CmsFaq;
use App\Services\Ads\AdService;
use App\Services\Rss\RssService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;
use Laravel\Nova\Fields\Date;
use Vedmant\FeedReader\FeedReader;

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
	    if(!auth()->user() && config('app.is_coming_soon')) {
	        return view('pages.coming_soon');
        }

		//TODO get the last ads with  : $lastAdsAdded = AttributionAdEvents::orderBy('id', 'desc')->take(2)->get();
		//TODO get the last ads tag "Partenaires"


		$ads = Ad::whereHas('attributionAd', function (Builder $query) {
			$query->where('ad_status_id', '=', AdStatus::APPROVE_ID);
		})->take(4)->orderBy('created_at', 'desc')->get()->shuffle();

		$adsPartner = Ad::whereHas('attributionAd', function (Builder $query) {
			$query->where('ad_status_id', '=', AdStatus::APPROVE_ID);
		})->where('is_partner', '=', 1)->take(2)->orderBy('created_at', 'desc')->get();

//TODO, in the V2, inject faq section content into the the template
//$cmsFaq = CmsFaq::where('page_name', '=', Route::currentRouteName())->get();
		$rssNews = $rssService->getTdlNews();

		return view('pages.homepage', compact('ads', 'adsPartner', 'rssNews'));
	}
}
