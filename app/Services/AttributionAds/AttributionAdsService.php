<?php

namespace App\Services\AttributionAds;

use App\Models\Ad;
use App\Models\Region;
use App\Repositories\AttributionAds\AttributionAdsRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class AttributionAdsService
 * @package App\Services\AttributionAds
 */
class AttributionAdsService
{
	protected $repository;

	/**
	 * AttributionAdsService constructor.
	 * @param AttributionAdsRepository $attributionAdsRepository
	 */
	public function __construct(AttributionAdsRepository $attributionAdsRepository)
	{
		$this->repository = $attributionAdsRepository;
	}

	/**
	 * @param int $idUser
	 * @return Builder[]|Collection
	 */
	public function findAllByUserModerator(int $idUser)
	{
		return $this->repository->findAllByModeratorId($idUser);
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Support\Collection
	 */
	public function show(Request $request)
	{
		$idRegions = $request->input('regions_location_researches');
		$data = [];
		foreach ($request->input() as $item => $value) {
			$data[$item] = $value;
		}

		if (!isset($data['ad_type'])) {
			$data['ad_type'] = [];
			array_push($data['ad_type'], "landOfferAd", "landSeekAd", "jobOfferAd", "jobSeekAd");
		}

		if ($idRegions && !in_array('0', $idRegions)) {
			$regions = Region::with('ads')->whereIn('id', $idRegions)->get();
		} else {
			$regions = Region::all();
		}

		$attributionAds = collect();
		if(isset ($data['ad_title'])){
			$adsByTitle = Ad::where('title', 'like', '%'.$data['ad_title'].'%')->get();
			foreach($adsByTitle as $adByTitle){
				$attributionAds[$adByTitle->attributionAd->id] = $adByTitle->attributionAd->load('ad');
			}
		}

		foreach ($regions as $region) {
			$regionAds = $region->ads;
			foreach ($regionAds as $key => $ad) {
				$isAdAttributedToModeratorLogged = $ad->attributionAd->user_moderator_id === auth()->id();
				$isAdInRangeDateSelected = $ad->attributionAd->created_at->format('d/m/Y') >= $data['dateResearchRange'];
				foreach ($data['ad_type'] as $adType){
					if ($isAdAttributedToModeratorLogged && $isAdInRangeDateSelected && $ad->$adType) {
						$attributionAds[$ad->attributionAd->id] = $ad->attributionAd->load('ad');
					}
				}
			}
		}
		return $attributionAds;
	}
}