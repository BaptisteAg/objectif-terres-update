<?php

namespace App\Http\Controllers\HomePage;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\AdStatus;
use App\Services\Ads\AdService;
use App\Services\Rss\RssService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
		//TODO get the last ads with  : $lastAdsAdded = AttributionAdEvents::orderBy('id', 'desc')->take(2)->get();
		//TODO get the last ads tag "Partenaires"
//		$ads = [];
//		$firstAd = $this->adService->find(6);
//		array_push($ads, $firstAd);
//		$secondAd = $this->adService->find(22);
//		array_push($ads, $secondAd);

		$ads = Ad::whereHas('attributionAd', function (Builder $query) {
			$query->where('ad_status_id', '=', AdStatus::APPROVE_ID);
		})->take(2)->orderBy('created_at', 'desc')->get();

		$rssNews = $rssService->getTdlNews();
		return view('pages.homepage', compact('ads', 'rssNews'));
	}
}
