<?php namespace App\Services\Researches;


use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\City;
use App\Models\Department;
use App\Models\Region;
use App\Models\Research;
use App\Repositories\Ads\AdRepository;
use App\Repositories\Researches\ResearchRepository;
use App\Services\Locations\LocationService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ResearchService
{
	/**
	 * @var ResearchRepository
	 */
	protected $repository;
	protected $locationService;
	protected $adRepository;

	/**
	 * ResearchService constructor.
	 * @param ResearchRepository $repository
	 * @param LocationService $locationService
	 * @param AdRepository $adRepository
	 */
	public function __construct(ResearchRepository $repository, LocationService $locationService, AdRepository $adRepository)
	{
		$this->repository = $repository;
		$this->locationService = $locationService;
		$this->adRepository = $adRepository;
	}


	/**
	 * @param Request $request
	 * @return mixed
	 * @throws \Throwable
	 */
	public function create(Request $request)
	{
		$url = (url()->previous());
		$urlParsed = parse_url($url);
		parse_str($urlParsed['query'], $urlQuery);
		if ($request->input('page')) {
			unset($urlQuery['page']);
		}
		$urlGet = http_build_query($urlQuery);

		$data = [];
		foreach ($request->input() as $item => $value) {
			$data[$item] = $value;
		}
		$data['url'] = '?' . $urlGet;
		$research = DB::transaction(function () use ($data) {
			$research = $this->repository->create($data);

			return $research;
		});

		return $research;
	}

	/**
	 * @param int $id
	 * @return Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function find(int $id)
	{
		$research = $this->repository->find($id);

		return $research;
	}

	/**
	 * @param int $id
	 * @return Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function findAllByUser(int $id)
	{
		$researches = $this->repository->findAllByUser($id);
		return $researches;
	}

	/**
	 * @return array
	 */
	public function findNewRelatedAds(): array
	{
		$researches = $this->repository->findAllResearchesWithAlertActive();
		$researchesWithNewAds = [];
		foreach ($researches as $research) {
			$ads = collect();
			$adsFilter = (new Ad)->newQuery();
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
				$adsFilter->filterWhereHasIn($research->offerGenres()->pluck('offer_genres.id')->toArray(), $research->ad_type . '.offerGenres', 'offer_genre_id');
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
				$adsFilter->filterWhereHasWhere($research->has_houses, $research->ad_type, '=', 'has_buildings');
			}
			if ($research->has_pics === 1) {
				$adsFilter->whereHas('documents', function (Builder $query) {
					$query->whereIn('type', ['image']);
				});
			}
			if ($research->productionGenres()->exists()) {
				$adsFilter->filterWhereHasIn($research->productionGenres()->pluck('production_genres.id')->toArray(), $research->ad_type . '.productionGenres', 'production_genres.id');
			}
			if ($research->bioCertifications()->exists()) {
				$adsFilter->filterWhereHasIn($research->bioCertifications()->pluck('bio_certifications.id')->toArray(), $research->ad_type . '.bioCertifications', 'bio_certifications.id');
			}
			if ($research->jobOfferTypes()->exists()) {
				$adsFilter->filterWhereHasIn($research->jobOfferTypes()->pluck('job_offer_types.id')->toArray(), $research->ad_type . '.jobOfferTypes', 'job_offer_types.id');
			}

			$adsFilter->whereHas('attributionAd', function (Builder $query) use ($research) {
				$query->where('published_on', '>', $research->updated_at);
			});
			$newAds = $adsFilter->get();

			if (!$newAds->isEmpty()) {
				$researchesWithNewAds[$research->id] = $newAds;
				$research->updated_at = Carbon::now();
				$research->save();
			}
		}

		return $researchesWithNewAds;
	}

	/**
	 * @param Request $filters
	 * @return array
	 */
	public function index(Request $filters)
	{
		$ads = $this->filter($filters);
		return $ads;
	}

	/**
	 * @param Request $filters
	 * @return array
	 */
	public function filter(Request $filters)
	{
		$adsFilter = (new Ad)->newQuery();
		//Filter by type of ads
		$adsTypeSelected = '';

		if ($filters->has('ad_category') && $filters->input('ad_category') === "all") {
			$ads = $this->adRepository->findAllPublished(true);
			$adsTypeSelected = 'all';
			return [$ads, $adsTypeSelected];
		}

		if ($filters->has('ad_category') && $filters->has('offer_type')) {
			$adsTypeSelected = $filters->input('ad_category') . $filters->input('offer_type');
		} else {
			abort(redirect()->back()->with('warning', 'Aucun catégorie d\'annonce séléctionnée'));
		}

		//If request, filter by departments locations and all locations related to the departments selected
		$adsFilter->whereNull('project_id');
		if ($filters->has('cities_location_researches_ids')) {
			if (!is_null($filters->input('radius_research'))) {
				$cityIds = $this->locationService->getCitiesInRadius($filters->input('cities_location_researches_ids'), $filters->input('radius_research'));
				$adsFilter->filterLocations('cities', $cityIds);
			} else {
				$adsFilter->filterLocations('cities', $filters->input('cities_location_researches_ids'));
			}

		} //If request, filter by departments locations and all locations related to the departments selected
		else if ($filters->has('departments_location_researches_ids')) {
			$departmentsCodes = Department::whereIn('id', $filters->input('departments_location_researches_ids'))->get('code')->toArray();
			$adsFilter->filterLocations('departments', $filters->input('departments_location_researches_ids'));
			$adsFilter->filterSubLocations('cities', $departmentsCodes, 'cities.department_code');
		} //If request, filter by regions locations and all locations related to the regions selected
		else if ($filters->has('regions_location_researches_ids')) {
			if (!in_array(-1, $filters->input('regions_location_researches_ids'))) {
				$regionsCodes = Region::whereIn('id', $filters->input('regions_location_researches_ids'))->get('code')->toArray();
				$departmentsCodes = Department::whereIn('region_code', $regionsCodes)->get('code')->toArray();
				$adsFilter->filterLocations('regions', $filters->input('regions_location_researches_ids'));
				$adsFilter->filterSubLocations('departments', $regionsCodes, 'departments.region_code');
				$adsFilter->filterSubLocations('cities', $departmentsCodes, 'cities.department_code');
			}
		}

		if ($filters->has('offer_genres')) {
			$adsFilter->filterWhereHasIn($filters->input('offer_genres'), $adsTypeSelected . '.offerGenres', 'offer_genre_id');
		}
		if (!is_null($filters->input('surfaces_research')) && $filters->input('surfaces_research') !== "0") {
			if ($adsTypeSelected === 'landSeekAd') {
				if ($filters->input('surfaces_research') === "+100") {
					$adsFilter->filterWhereHasWhere('100', $adsTypeSelected, '>=', 'surface_range_max');
				} else {
					$adsFilter->filterWhereHasWhere($filters->input('surfaces_research'), $adsTypeSelected, '<=', 'surface_range_max');
				}
			} else if ($adsTypeSelected === 'landOfferAd') {

				if ($filters->input('surfaces_research') === "+100") {
					$adsFilter->filterWhereHasWhere('100', $adsTypeSelected, '>=', 'surface');
				} else {
					$adsFilter->filterWhereHasWhere($filters->input('surfaces_research'), $adsTypeSelected, '<=', 'surface');
				}
			}
		}

		if (!is_null($filters->input('price_min'))) {
			$adsFilter->whereHas($adsTypeSelected, function (Builder $query) use ($filters) {
				$query->where('price', '>=', $filters->input('price_min'));
				$query->orWhere('rent_price', '>=', $filters->input('price_min'));
			});
		}

		if (!is_null($filters->input('price_max'))) {
			$adsFilter->whereHas($adsTypeSelected, function (Builder $query) use ($filters) {
				$query->where('price', '<=', $filters->input('price_max'));
				$query->orWhere('rent_price', '<=', $filters->input('price_max'));
			});
		}

		if ($filters->has('has_buildings')) {
			$adsFilter->filterWhereHasWhere($filters->input('has_buildings'), $adsTypeSelected, '=', 'has_buildings');
		}

		if ($filters->has('has_picture')) {
			$adsFilter->whereHas('documents', function (Builder $query) {
				$query->whereIn('type', 'image');
			});
		}

		if ($filters->has('production_genres')) {
			$adsFilter->filterWhereHasIn($filters->input('production_genres'), $adsTypeSelected . '.productionGenres', 'production_genres.id');
		};

		if ($filters->has('bio_certifications')) {
			$adsFilter->filterWhereHasIn($filters->input('bio_certifications'), $adsTypeSelected . '.bioCertifications', 'bio_certifications.id');
		}

		if ($filters->has('offer_genres')) {
			$adsFilter->filterWhereHasIn($filters->input('offer_genres'), $adsTypeSelected . '.offerGenres', 'offer_genres.id');
		}
		if (!is_null($filters->input('jobOfferType'))) {
			$adsFilter->filterWhereHasWhere($filters->input('jobOfferType'), $adsTypeSelected . '.jobOfferTypes', '=', 'job_offer_types.id');
		}

		$adsFilter->filterAdTypes(array($adsTypeSelected), '');
		// TODO show only ads approved by moderators
		$validatedStatus = AdStatus::where('id', '=', AdStatus::APPROVE_ID)->first();
		$adsFilter->filterWhereHasWhere($validatedStatus->id, 'attributionAd', '=', 'ad_status_id');


		if ($filters->has('order') && $filters->has('sort')) {
			if ($filters->input('sort') === 'date') {
				$adsFilter->orderBy('created_at', $filters->input('order'));
			} else {

				$adsTypeSelectedTableName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $adsTypeSelected)) . 's';
				$adsFilter->join($adsTypeSelectedTableName, 'ads.id', '=', $adsTypeSelectedTableName . '.ad_id')
					->orderBy($filters->input('sort'), $filters->input('order'))
					->select('ads.*');
			}
		} else {
			$adsFilter->orderByDesc('created_at');
		}

		$ads = $adsFilter->with(
			'userPp',
			'project.projectStatus',
			'attributionAd',

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
			->paginate(15);

		return [$ads, $adsTypeSelected];
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
