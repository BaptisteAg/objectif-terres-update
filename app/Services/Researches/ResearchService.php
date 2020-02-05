<?php namespace App\Services\Researches;


use App\Models\Ad;
use App\Models\Department;
use App\Models\Region;
use App\Repositories\Researches\ResearchRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResearchService
{
	/**
	 * @var ResearchRepository
	 */
	protected $repository;

	public function __construct(ResearchRepository $repository)
	{
		$this->repository = $repository;
	}


	public function create(Request $request)
	{
		$url = (url()->previous());
		$urlGet = substr($url, strpos($url, "?"));

		$data = [];
		foreach ($request->input() as $item => $value) {
			$data[$item] = $value;
		}
		$data['url'] = $urlGet;

		$research = DB::transaction(function () use ($data) {
			$research = $this->repository->create($data);

			return $research;
		});

		return $research;
	}

	public function find(int $id)
	{
		$research = $this->repository->find($id);

		return $research;
	}

	public function findAllByUser(int $id)
	{
		$researches = $this->repository->findAllByUser($id);

		return $researches;
	}

	public function findAll()
	{

		$researches = $this->repository->all();
		return $researches;
	}

	public function findRelatedAds(int $id)
	{
		$ads = $this->repository->findRelatedAds($id);
		return $ads;
	}

	public function findNewRelatedAds()
	{
		$researches = $this->repository->all();
		$newAdsInResearch = [];
		foreach ($researches as $research) {
			$id = $research->id;
			$date = $research->updated_at;
			$newAds = $this->repository->findRelatedAds($id)->where('created_at', '>=', $date);
			if (!$newAds->isEmpty()) {
				$newAdsInResearch[$research->id] = $this->repository->findRelatedAds($id)->where('created_at', '>=', $date);
			}
		}

		return $newAdsInResearch;
	}

	public function index(Request $request)
	{
		$adTypeInput = $request->input('ad_type');
		$adCategory = $request->input('ad_category');
		$idRegions = $request->input('regions_location_researches');

		$data = [];
		foreach ($request->input() as $item => $value) {
			$data[$item] = $value;
		}

		if ($adCategory === 'land') {
			$adType = ($adTypeInput === 'offer_ads') ? 'landOfferAd' : 'landSeekAd';
		} else if ($adCategory === 'offer') {
			$adType = ($adTypeInput === 'offer_ads') ? 'jobOfferAd' : 'jobSeekAd';
		} else {
			$adType = $adTypeInput;
		}

		if ($idRegions && !in_array('0', $idRegions)) {
			$regions = Region::with('ads')->whereIn('id', $idRegions)->get();
		} else {
			$regions = Region::all();
		}

		$ads = collect();

		foreach ($regions as $region) {
			$regionAds = $region->ads;
			foreach ($regionAds as $key => $ad) {
				if ($ad->$adType) {
					$ads[$ad->id] = $ad;
				}
			}
		}

//		DB::enableQueryLog();
//		$ads = Ad::whereHas('locationables', function (Builder $query) use ($idRegions) {
//			$query->where('locationables.locationable_ad_type', Region::class);
//			foreach ($idRegions as $idRegion) {
//				$query->orWhere('locationables.locationable_ad_id', $idRegion);
//			}
//		})->get();
//
//		dd(DB::getQueryLog());

		return [$ads, $adType, $regions];
	}

	public function destroy(Request $request)
	{
		$researchId = $request->input('research');
		$research = $this->find($researchId);
		$research->delete();
	}
}
