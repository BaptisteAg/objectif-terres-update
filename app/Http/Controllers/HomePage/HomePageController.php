<?php
namespace App\Http\Controllers\HomePage;

use App\Http\Controllers\Controller;
use App\Models\Ad;
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

	public function show()
	{
		//TODO get the last ads with  : $lastAdsAdded = Ad::orderBy('id', 'desc')->take(2)->get();
		$ads = [];
		$firstAd = $this->adService->find(6);
		array_push($ads, $firstAd);
		$secondAd = $this->adService->find(22);
		array_push($ads, $secondAd);


		return view('pages.homepage', compact('ads'));

	}
}