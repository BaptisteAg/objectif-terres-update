<?php namespace App\Services\Researches;


use App\Models\Ad;
use App\Models\City;
use App\Models\Department;
use App\Models\Region;
use App\Models\Research;
use App\Repositories\Researches\ResearchRepository;
use App\Services\Locations\LocationService;
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
	protected $locationService;

	public function __construct(ResearchRepository $repository, LocationService $locationService)
	{
		$this->repository = $repository;
		$this->locationService = $locationService;
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

	public function findNewRelatedAds()
	{
		$researches = $this->repository->findAllResearchesWithAlertActive();
		$newAdsInResearch = [];
		foreach ($researches as $research) {
			$ads = collect();
			$adsFilter = (new Ad)->newQuery();

			$adsFilter->where('updated_at', '>', $research->updated_at);
			$adsFilter->filterAdTypes([$research->ad_type], '');

			if ($research->cities()->exists()) {
				$adsFilter->filterLocations('cities', $research->cities()->pluck('cities.id')->toArray());
			} else if ($research->departments()->exists()) {
				$adsFilter->filterLocations('departments', $research->departments()->pluck('departments.id')->toArray());
				$adsFilter->filterSubLocations('cities', $research->departments()->pluck('code')->toArray(), 'cities.department_code');

			} else if ($research->regions()->exists()) {
				$regionsCodes = $research->regions()->pluck('code')->toArray();
				$departmentsCodes = Department::whereIn('region_code', $regionsCodes)->get('code')->toArray();
				$adsFilter->filterLocations('regions', $research->regions()->pluck('regions.id')->toArray());
				$adsFilter->filterSubLocations('departments', $regionsCodes, 'departments.region_code');
				$adsFilter->filterSubLocations('cities', $departmentsCodes, 'cities.department_code');
			}
			if ($research->offerGenres()->exists()) {
				$adsFilter->filterArrayDataInRelationModel($research->offerGenres()->pluck('offer_genres.id')->toArray(), $research->ad_type . '.offerGenres', 'offer_genre_id');
			}

			if (!is_null($research->surface_min)) {
				if ($research->ad_type === 'landSeekAd') {
					$adsFilter->whereHas($research->ad_type, function (Builder $query) use ($research) {
						$query->where('surface_range_min', '>=', $research->surface_min);
					});
				} else if ($research->ad_type === 'landOfferAd') {
					$adsFilter->whereHas($research->ad_type, function (Builder $query) use ($research) {
						$query->where('surface', '>=', $research->surface_min);
					});
				}
			}
			if (!is_null($research->surface_max)) {
				if ($research->ad_type === 'landSeekAd') {
					$adsFilter->whereHas($research->ad_type, function (Builder $query) use ($research) {
						$query->where('surface_range_max', '<=', $research->surface_max);
					});
				} else if ($research->ad_type === 'landOfferAd') {
					$adsFilter->whereHas($research->ad_type, function (Builder $query) use ($research) {
						$query->where('surface', '<=', $research->surface_max);
					});
				}
			}
			if (!is_null($research->price_min)) {
				$adsFilter->whereHas($research->ad_type, function (Builder $query) use ($research) {
					$query->where('price', '>=', $research->price_min);
					$query->orWhere('rent_price', '>=', $research->price_min);
				});
			}
			if (!is_null($research->price_max)) {
				$adsFilter->whereHas($research->ad_type, function (Builder $query) use ($research) {
					$query->where('price', '<=', $research->price_max);
					$query->orWhere('rent_price', '<=', $research->price_max);
				});
			}
			if (!is_null($research->has_houses)) {
				$adsFilter->filterDataInRelationModel($research->has_houses, $research->ad_type, '=', 'has_buildings');
			}
			if ($research->has_pics === 1) {
				$adsFilter->whereHas('documents', function (Builder $query) {
					$query->whereIn('type', ['image']);
				});
			}
			if ($research->productionGenres()->exists()) {
				$adsFilter->filterArrayDataInRelationModel($research->productionGenres()->pluck('production_genres.id')->toArray(), $research->ad_type . '.productionGenres', 'production_genres.id');
			}
			if ($research->bioCertifications()->exists()) {
				$adsFilter->filterArrayDataInRelationModel($research->bioCertifications()->pluck('bio_certifications.id')->toArray(), $research->ad_type . '.bioCertifications', 'bio_certifications.id');
			}

			if ($research->jobOfferTypes()->exists()) {
				$adsFilter->filterDataInRelationModel($research->jobOfferTypes()->pluck('job_offer_types.id'), $research->ad_type . '.jobOfferTypes', '=', 'job_offer_types.id');
			}
			$newAds = $adsFilter->get();

			if (!$newAds->isEmpty()) {
				$newAdsInResearch[$research->id] = $newAds;
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
	}

	public function filter(Request $filters)
	{
		$ads = collect();
		$adsFilter = (new Ad)->newQuery();
		//Filter by type of ads
		$adTypeSelected = '';
		if ($filters->has('ad_category') && $filters->has('offer_type')) {
			$adTypeSelected = $filters->input('ad_category') . $filters->input('offer_type');
		}

		//If request, filter by departments locations and all locations related to the departments selected
		if ($filters->has('cities_location_researches_ids')) {
			if (!is_null($filters->input('radius_research'))) {
				$cityIds = $this->locationService->getCitiesInRadius ($filters->input('cities_location_researches_ids'),$filters->input('radius_research'));
				$adsFilter->filterLocations('cities', $cityIds);
			}else {
				$adsFilter->filterLocations('cities', $filters->input('cities_location_researches_ids'));
			}


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

		if ($filters->has('offer_genres')) {
			$adsFilter->filterArrayDataInRelationModel($filters->input('offer_genres'), $adTypeSelected . '.offerGenres', 'offer_genre_id');
		}
		if (!is_null($filters->input('surfaces_research')) && $filters->input('surfaces_research') !== "0") {
			if ($adTypeSelected === 'landSeekAd') {
				if ($filters->input('surfaces_research') === "+100") {
					$adsFilter->filterDataInRelationModel('100', $adTypeSelected, '>=', 'surface_range_max');
				} else {
					$adsFilter->filterDataInRelationModel($filters->input('surfaces_research'), $adTypeSelected, '<=', 'surface_range_max');
				}
			} else if ($adTypeSelected === 'landOfferAd') {
				if ($filters->input('surfaces_research') === "+100") {
					$adsFilter->filterDataInRelationModel('100', $adTypeSelected, '>=', 'surface');
				} else {
					$adsFilter->filterDataInRelationModel($filters->input('surfaces_research'), $adTypeSelected, '<=', 'surface');
				}
			}
		}

		if (!is_null($filters->input('price_min'))) {
			$adsFilter->whereHas($adTypeSelected, function (Builder $query) use ($filters) {
				$query->where('price', '>=', $filters->input('price_min'));
				$query->orWhere('rent_price', '>=', $filters->input('price_min'));
			});
		}

		if (!is_null($filters->input('price_max'))) {
			$adsFilter->whereHas($adTypeSelected, function (Builder $query) use ($filters) {
				$query->where('price', '<=', $filters->input('price_max'));
				$query->orWhere('rent_price', '<=', $filters->input('price_max'));
			});
		}

		if ($filters->has('has_buildings')) {
			$adsFilter->filterDataInRelationModel($filters->input('has_buildings'), $adTypeSelected, '=', 'has_buildings');
		}

		if ($filters->has('has_picture')) {
			$adsFilter->whereHas('documents', function (Builder $query) {
				$query->whereIn('type', 'image');
			});
		}

		if ($filters->has('production_genres')) {
			$adsFilter->filterArrayDataInRelationModel($filters->input('production_genres'), $adTypeSelected . '.productionGenres', 'production_genres.id');
		};

		if ($filters->has('bio_certifications')) {
			$adsFilter->filterArrayDataInRelationModel($filters->input('bio_certifications'), $adTypeSelected . '.bioCertifications', 'bio_certifications.id');
		}

		if ($filters->has('offer_genres')) {
			$adsFilter->filterArrayDataInRelationModel($filters->input('offer_genres'), $adTypeSelected . '.offerGenres', 'offer_genres.id');
		}
		if (!is_null($filters->input('jobOfferType'))) {
			$adsFilter->filterDataInRelationModel($filters->input('jobOfferType'), $adTypeSelected . '.jobOfferTypes', '=', 'job_offer_types.id');
		}

		$adsFilter->filterAdTypes(array($adTypeSelected), '');

		$ads = $adsFilter->with(
			'userPp',
			'project.projectStatus',

			'cities',
			'cities.department',
			'cities.department.region',
			'departments',
			'departments.region',
			'regions',

			'landSeekAd',
			'landOfferAd',
			'jobOfferAd',
			'jobSeekAd')
			->orderByDesc('created_at')
			->get();
		return [$ads, $adTypeSelected];
	}

	/**
	 * @param Research $research
	 */
	public function deleteAlert(Research $research)
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
