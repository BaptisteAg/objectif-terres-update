<?php
namespace App\Http\Controllers\HomePage;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\City;
use App\Models\Department;
use App\Models\Region;
use App\Services\Ads\AdService;

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

	public function show(AdService $adService)
	{
		//TODO get the last ads with  : $lastAdsAdded = AttributionAdEvents::orderBy('id', 'desc')->take(2)->get();
        //TODO get the last ads tag "Partenaires"
//		$ads = [];
//		$firstAd = $this->adService->find(6);
//		array_push($ads, $firstAd);
//		$secondAd = $this->adService->find(22);
//		array_push($ads, $secondAd);

		$ads = Ad::latest()->take(2)->get();

		return view('pages.homepage', compact('ads'));

	}
}
