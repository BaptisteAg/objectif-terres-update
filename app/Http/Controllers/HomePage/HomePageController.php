<?php
namespace App\Http\Controllers\HomePage;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\City;
use App\Models\Department;
use App\Models\Region;
use App\Services\Ads\AdService;
use Illuminate\Support\Collection;

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

		//TODO get the last ads with  : $lastAdsAdded = Ad::orderBy('id', 'desc')->take(2)->get();
//		$ads = [];
//		$firstAd = $this->adService->find(6);
//		array_push($ads, $firstAd);
//		$secondAd = $this->adService->find(22);
//		array_push($ads, $secondAd);

		$ads = $adService->findAll();

		$adsCountByRegionId = [];

		foreach($ads as $ad) {
            if(count($ad->cities)) {
                /** @var City $city */
                foreach($ad->cities as $city) {
                    if($city->department && $city->department->region) {
                        if(!isset($adsCountByRegionId[$city->department->region->id])) {
                            $adsCountByRegionId[$city->department->region->id] = 1;
                        }
                        $adsCountByRegionId[$city->department->region->id]++;
                    }
                }
            }

            if(count($ad->departments)) {
                /** @var Department $department */
                foreach($ad->departments as $department) {
                    if($department->region) {
                        if(!isset($adsCountByRegionId[$department->region->id])) {
                            $adsCountByRegionId[$department->region->id] = 1;
                        }
                        $adsCountByRegionId[$department->region->id]++;
                    }
                }
            }

		    if(count($ad->regions)) {
                /** @var Region $foundRegion */
                foreach($ad->regions as $region) {
                    if(!isset($adsCountByRegionId[$region->id])) {
                        $adsCountByRegionId[$region->id] = 1;
                    }
                    $adsCountByRegionId[$region->id]++;
                }
            }
        }

		return view('pages.homepage', compact('ads', 'adsCountByRegionId'));

	}
}