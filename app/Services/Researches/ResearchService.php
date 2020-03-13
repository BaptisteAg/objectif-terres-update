<?php namespace App\Services\Researches;


use App\Models\Ad;
use App\Models\Department;
use App\Models\Region;
use App\Models\Research;
use App\Repositories\Researches\ResearchRepository;
use Carbon\Carbon;
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
			$newAds = $this->repository->findRelatedAds($id)->where('updated_at', '>=', $date);
			if (!$newAds->isEmpty()) {
				$newAdsInResearch[$research->id] = $this->repository->findRelatedAds($id)->where('created_at', '>=', $date);
				$research->updated_at = Carbon::now();
				$research->save();
			}
		}

		return $newAdsInResearch;
	}

	public function index(Request $filters)
	{
		$ads = $this->filter($filters);
		return $ads;


//		$adTypeInput = $request->input('ad_type');
//		$adCategory = $request->input('ad_category');
//		$idRegions = $request->input('regions_location_researches');
//
//		$data = [];
//		foreach ($request->input() as $item => $value) {
//			$data[$item] = $value;
//		}
//
//		if ($adCategory === 'land') {
//			$adType = ($adTypeInput === 'offer_ads') ? 'landOfferAd' : 'landSeekAd';
//		} else if ($adCategory === 'offer') {
//			$adType = ($adTypeInput === 'offer_ads') ? 'jobOffer' : 'jobSeekAd';
//		} else {
//			$adType = $adTypeInput;
//		}
//
//		if ($idRegions && !in_array('0', $idRegions)) {
//			$regions = Region::with('ads')->whereIn('id', $idRegions)->get();
//		} else {
//			$regions = Region::all();
//		}
//
//		$ads = collect();
//
//		foreach ($regions as $region) {
//			$regionAds = $region->ads;
//			foreach ($regionAds as $key => $ad) {
//				if ($ad->$adType) {
//					$ads[$ad->id] = $ad;
//				}
//			}
//		}


	}


	public function filter(Request $filters)
	{

		dump($filters->input());
		$ads = collect();
		$adsFilter = (new Ad)->newQuery();

		//Filter by type of ads
		$adTypeSelected = '';
		if ($filters->has('ad_type') && $filters->has('ad_category')) {
			$adTypeSelected = $filters->input('ad_category') . $filters->input('ad_type');
			$adsFilter->filterAdTypes(array($adTypeSelected), '');
		}

		//If request, filter by departments locations and all locations related to the departments selected
		if ($filters->has('cities_location_researches_ids')) {
			$adsFilter->filterLocations('cities', $filters->input('cities_location_researches_ids'));
		} //If request, filter by departments locations and all locations related to the departments selected
		else if ($filters->has('departments_location_researches_ids')) {
			$departmentsCodes = Department::whereIn('id', $filters->input('departments_location_researches_ids'))->get('code')->toArray();
			$adsFilter->filterLocations('departments', $filters->input('departments_location_researches_ids'));
			$adsFilter->filterSubLocations('cities', $departmentsCodes, 'cities.department_code');
		} //If request, filter by regions locations and all locations related to the regions selected
		else if ($filters->has('regions_location_researches_ids')) {
			if (!in_array(0, $filters->input('regions_location_researches_ids'))) {
				$regionsCodes = Region::whereIn('id', $filters->input('regions_location_researches_ids'))->get('code')->toArray();
				$departmentsCodes = Department::whereIn('region_code', $regionsCodes)->get('code')->toArray();
				$adsFilter->filterLocations('regions', $filters->input('regions_location_researches_ids'));
				$adsFilter->filterSubLocations('departments', $regionsCodes, 'departments.region_code');
				$adsFilter->filterSubLocations('cities', $departmentsCodes, 'cities.department_code');
			}
		}

		if($filters->has('offer_genres')){
			$adsFilter->filterDataInRelationModel($filters->input('offer_genres'), $adTypeSelected.'.offerGenres', 'offer_genre_id');
		}
		if($filters->has('surfaces_researches')){
			if ($adTypeSelected === 'landSeekAds'){
				$adsFilter->whereHas($adTypeSelected, function (Builder $query) use ($filters){
					$query->where('surface_range_min', '>=',$filters->input('surfaces_researches'));
				});
			}
			else {
				$adsFilter->whereHas($adTypeSelected, function (Builder $query) use ($filters){
					$query->where('surface', '>=',$filters->input('surfaces_researches'));
				});
			}
		}


		$ads = $adsFilter->get();
		dd($ads);
		return [$ads, $adTypeSelected];
	}


	/**
	 * @param Research $research
	 */
	public
	function deleteAlert(Research $research)
	{
		$research->has_alert = 0;
		$research->save();
	}

	/**
	 * @param Research $research
	 * @return mixed
	 */
	public
	function destroy(Research $research)
	{
		return $this->repository->delete($research->id);
	}
}
