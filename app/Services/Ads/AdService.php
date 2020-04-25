<?php namespace App\Services\Ads;

use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\AttributionAd;
use App\Models\Department;
use App\Models\Region;
use App\Models\User;
use App\Repositories\Ads\AdRepository;
use App\Repositories\Ads\JobOfferAdRepository;
use App\Repositories\Ads\JobSeekAdRepository;
use App\Repositories\Ads\LandOfferAdRepository;
use App\Repositories\Ads\LandSeekAdRepository;
use App\Repositories\Ads\ProductionGenreRepository;
use App\Repositories\AttributionAds\AttributionAdsRepository;
use App\Services\Users\UserService;
use DateTime;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Routing\RouteCollectionBuilder;

/**
 * Class AdService
 * @package App\Services\Ads
 */
class AdService
{
	/**
	 * @var AdRepository
	 */
	protected $repository;
	/**
	 * @var LandSeekAdRepository
	 */
	protected $landSeekAdRepository;
	/**
	 * @var LandOfferAdRepository
	 */
	protected $landOfferAdRepository;
	/**
	 * @var ProductionGenreRepository
	 */
	protected $productionGenreRepository;
	/**
	 * @var JobOfferAdRepository
	 */
	protected $jobOfferAdRepository;
	/**
	 * @var JobSeekAdRepository
	 */
	protected $jobSeekAdRepository;
	/**
	 * @var AttributionAdsRepository
	 */
	protected $attributionAdsRepository;

	/**
	 * @var UserService
	 */
	protected $userService;

	/**
	 * AdService constructor.
	 * @param AdRepository $repository
	 * @param AttributionAdsRepository $attributionAdsRepository
	 * @param LandSeekAdRepository $landSeekAdRepository
	 * @param LandOfferAdRepository $landOfferAdRepository
	 * @param JobOfferAdRepository $jobOfferAdRepository
	 * @param JobSeekAdRepository $jobSeekAdRepository
	 * @param ProductionGenreRepository $productionGenreRepository
	 * @param UserService $userService
	 */
	public function __construct(
		AdRepository $repository,
		AttributionAdsRepository $attributionAdsRepository,
		LandSeekAdRepository $landSeekAdRepository,
		LandOfferAdRepository $landOfferAdRepository,
		JobOfferAdRepository $jobOfferAdRepository,
		JobSeekAdRepository $jobSeekAdRepository,
		ProductionGenreRepository $productionGenreRepository,
		UserService $userService
	)
	{
		$this->repository = $repository;
		$this->attributionAdsRepository = $attributionAdsRepository;
		$this->landSeekAdRepository = $landSeekAdRepository;
		$this->landOfferAdRepository = $landOfferAdRepository;
		$this->jobOfferAdRepository = $jobOfferAdRepository;
		$this->jobSeekAdRepository = $jobSeekAdRepository;
		$this->productionGenreRepository = $productionGenreRepository;
		$this->userService = $userService;
	}

	/**
	 * @param $data
	 * @return mixed
	 * @throws \Throwable
	 */
    public function requestPublishing(array $data)
    {
        $ad =  DB::transaction(function() use($data) {

			$attributionAdData = [];
			$toModerateStatus = AdStatus::where('name', '=', 'À modérer')->first();

        	// Temporary : should be attributed by territory stored in Salesforce. If there is many moderators, one is picked randomly
			$userModerator = User::where('email', 'test.ot.moderateur@gmail.com')->first();
			if ($userModerator) {
				$attributionAdData['user_moderator_id'] = $userModerator->id;
				$attributionAdData['user_supervisor_id'] = $userModerator->id;
			} else {
				$attributionAdData['user_moderator_id'] = User::where('role', '>=', '1')->get()->random()->id;
			}
			$attributionAdData['ad_status_id'] = $toModerateStatus->id;
			$ad = $this->repository->create($data);
			$attributionAdData['ad_id'] = $ad->id;
			$this->attributionAdsRepository->create($attributionAdData);

			$adData = $data[$data["ad_type"]];
			$adData["ad_id"] = $ad->id;

            $this->storeSubAd($data["ad_type"], $adData);

            return $ad;
        });

		return $ad;
	}

    /**
     * Create the ad without requesting to publish it
     *
     * @param array $data
     * @return mixed
     * @throws \Throwable
     */
    public function create(array $data)
    {
        $ad =  DB::transaction(function() use($data) {

            $ad = $this->repository->create($data);

            $adData = $data[$data["ad_type"]];
            $adData["ad_id"] = $ad->id;

            $this->storeSubAd($data["ad_type"], $adData);

            return $ad;
        });

        return $ad;
    }

    protected function storeSubAd(string $adType, array $data)
    {
        if ($adType === "land_seek") {
            $landSeekAd = $this->landSeekAdRepository->create($data);
        }
        else if ($adType === "land_offer") {
            $landOfferAd = $this->landOfferAdRepository->create($data);
        }
        else if ($adType === "job_offer") {
            $jobOfferAd = $this->jobOfferAdRepository->create($data);
        }
        else if ($adType === "job_seek") {
            $jobSeekAd = $this->jobSeekAdRepository->create($data);
        }
    }

	/**
	 * @param int $id
	 * @return \App\Models\Ad
	 */
	public function find(int $id)
	{
		$ad = $this->repository->find($id);

		return $ad;
	}

	/**
	 * @return \App\Models\Ad[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
	 */
	public function findAll()
	{
		$ads = $this->repository->all();

		return $ads;
	}

	/**
	 * @param $idUser
	 * @return Collection
	 */
	public function findAllByUser($idUser): Collection
	{
		$ads = $this->repository->allByIdUser($idUser);

		return $ads;
	}

	/**
	 * @return array|\Illuminate\Support\Collection
	 */
	public function getProductionGenres()
	{
		return $this->productionGenreRepository->all();
	}

	/**
	 * @return array|\Illuminate\Support\Collection
	 */
	public function getProductionGenresFlattened()
	{
		return $this->productionGenreRepository->getFlattened();
	}

	/**
	 * @param Ad $ad
	 * @return void
	 * @throws \Exception
	 */
	public function delete(Ad $ad)
	{
		return $this->repository->destroy($ad->id);
	}


	/**
	 * Show all ads ads related to supervisor
	 * @return LengthAwarePaginator
	 */
	public function findAllByUserSupervisor() : LengthAwarePaginator
	{
		$supervisorLocationTerritoryCodes = $this->userService->getAllDepartmentsInSupervisorTerritory();
		$ads = $this->repository->findAllBySupervisorTerritoriesAndDates($supervisorLocationTerritoryCodes);
		return $ads;
	}


	/**
	 * @param array $dates
	 * @return mixed
	 */
	public function findAllByUserSupervisorBetweenDates(array $dates)
	{
		$supervisorLocationTerritoryCodes = $this->userService->getAllDepartmentsInSupervisorTerritory();
		$ads = $this->repository->findAllBySupervisorTerritoriesAndDates($supervisorLocationTerritoryCodes, $dates);
		return $ads;
	}


	/**
	 * @return Collection $ads
	 */
	public function findAllAdsInSupervisorTerritories(): Collection
	{
		$supervisorLocationTerritoryCodes = $this->userService->getAllDepartmentsInSupervisorTerritory();
		$ads = $this->repository->allInTerritories($supervisorLocationTerritoryCodes);
		return $ads;
	}

	/**
	 * @return Collection
	 */
	public function findAllValidateAdsInSupervisorTerritories(): Collection
	{
		$supervisorLocationTerritoryCodes = $this->userService->getAllDepartmentsInSupervisorTerritory();
		$validateStatusId = AdStatus::where('name', '=', 'Validée')->first()->id;
		$ads = $this->repository->allInTerritoriesByAdStatus($supervisorLocationTerritoryCodes, $validateStatusId);
		return $ads;
	}


	/**
	 * @return Collection
	 */
	public function findAllAdsAndProjectsGroupByUserPp(): Collection
	{
		$supervisorLocationTerritoryCodes = $this->userService->getAllDepartmentsInSupervisorTerritory();
		$users = $this->repository->allInTerritoriesGroupByUserPp($supervisorLocationTerritoryCodes);
		return $users;
	}


	/**
	 * @param Collection $ads
	 * @return array
	 */
	public function countAdsByCategories(Collection $ads): array
	{
		$numberOfAdsByCategories = [
			'landSeekAd' => 0,
			'landOfferAd' => 0,
			'jobOfferAd' => 0,
			'jobSeekAd' => 0
		];
		foreach ($ads as $ad) {
			if (isset($ad->landOfferAd)) {
				$numberOfAdsByCategories['landOfferAd']++;
			} else if (isset($ad->landSeekAd)) {
				$numberOfAdsByCategories['landSeekAd']++;
			} else if (isset($ad->jobSeekAd)) {
				$numberOfAdsByCategories['jobSeekAd']++;
			} else if (isset($ad->jobOfferAd)) {
				$numberOfAdsByCategories['jobOfferAd']++;
			}
		}
		return $numberOfAdsByCategories;
	}


	/**
	 * @param Collection $ads
	 * @return array
	 */
	public function countAdsByAdStatus(Collection $ads): array
	{
		$numberOfAdsByAdStatus = [
			'Validée' => 0,
			'En attente' => 0,
			'Refusée' => 0,
			'À modérer' => 0,
			'Archivée' => 0
		];
		foreach ($ads as $ad) {
			foreach ($numberOfAdsByAdStatus as $key => $value) {
				if ($key === $ad->attributionAd->adStatus->name) {
					$numberOfAdsByAdStatus[$key]++;
				}
			}
		}
		return $numberOfAdsByAdStatus;
	}

	/**
	 * @param Collection $ads
	 * @return array
	 */
	public function calculatePercentageOfAdsByAdStatus(Collection $ads): array
	{
		$numberOfAdsByAdStatus = $this->countAdsByAdStatus($ads);
		$sumOfAds = array_sum($numberOfAdsByAdStatus);

		$percentageOfAdsByAdStatus = array_map(function ($number) use ($sumOfAds) {
			return round($number * 100 / $sumOfAds);
		}, $numberOfAdsByAdStatus);

		return $percentageOfAdsByAdStatus;
	}

	/**
	 * Ad filters for supervisor dashboard
	 * @param Request $filters
	 * @return LengthAwarePaginator
	 */
	public function showForSupervisor(Request $filters): LengthAwarePaginator
	{
		$ads = $this->filter($filters, auth()->user()->role);
		return $ads;
	}

	/**
	 * @param Request $filters
	 * @param int $roleUser
	 * @return LengthAwarePaginator
	 */
	public function filter(Request $filters, int $roleUser): LengthAwarePaginator
	{
		$ads = collect();
		//START QUERY
		$adsFiltred = (new Ad())->newQuery();
		//Filter projetcs based on their locations if requested
		if ($filters->has('locations')) {
			$locations = $filters->input('locations');
			//If one or more departments are selected, get all ads located in departments and cities in departments
			if (array_key_exists('departments', $locations)) {
				$departmentsCode = Department::whereIn('id', $locations['departments'])->get('code')->toArray();
				$adsFiltred->where(function (Builder $query) use ($locations, $departmentsCode) {
					$query->filterLocations('departments', $locations['departments']);
					$query->filterSubLocations('cities', $departmentsCode, 'cities.department_code');
				});

				//If one or more regions are selected, get all ads located in regions, all ads in departments inside regions and cities in departments
			}
			if (array_key_exists('regions', $locations)) {
				$regionsCodes = Region::whereIn('id', $locations['regions'])->get('code')->toArray();
				$departmentsCode = Department::whereIn('region_code', $regionsCodes)->get('code')->toArray();
				$adsFiltred->where(function (Builder $query) use ($locations, $regionsCodes, $departmentsCode) {
					$query->filterLocations('regions', $locations['regions']);
					$query->filterSubLocations('departments', $regionsCodes, 'departments.region_code');
					$query->filterSubLocations('cities', $departmentsCode, 'cities.department_code');
				});
			}
		}
		//If a range of submitting date is selected, filter attribution ads based on creation date
		if (!is_null($filters->input('date_from')) && !is_null($filters->input('date_to'))) {
			$dateStartFormatted = DateTime::createFromFormat('d/m/Y', (string)$filters->input('date_from'))->format('Y-m-d');
			$dateEndFormatted = DateTime::createFromFormat('d/m/Y', (string)$filters->input('date_to'))->format('Y-m-d');
			$adsFiltred->where(function (Builder $query) use ($dateStartFormatted, $dateEndFormatted) {
				$query->whereHas('project', function (Builder $subQuery) use ($dateStartFormatted, $dateEndFormatted) {
					$subQuery->whereBetween('created_at', [$dateStartFormatted, $dateEndFormatted . " 23:59:59"]);
				});
				$query->orWhere(function (Builder $subQuery) use ($dateStartFormatted, $dateEndFormatted) {
					$subQuery->whereNull('project_id');
					$subQuery->whereHas('attributionAd', function (Builder $q) use ($dateStartFormatted, $dateEndFormatted) {
						$q->whereBetween('created_at', [$dateStartFormatted, $dateEndFormatted . " 23:59:59"]);

					});
				});
			});
		}
		//If one or many project status are selected, filter  ads based on their project status
		if ($filters->has('project_statuses')) {
			$adsFiltred->whereHas('project', function (Builder $query) use ($filters) {
				$query->whereIn('project_status_id', $filters->input('project_statuses'));
			});
		}
		//Filter ads based on their types if requested
		if ($filters->has('ad_type')) {
			$adsFiltred->filterAdTypes($filters->input('ad_type'), '');
		}

		//Filter ads by keywords
		if (!is_null($filters->input('ad_keywords'))) {
			$adsFiltred->where(function (Builder $query) use ($filters) {
				$query->where('title', 'like', '%' . $filters->input('ad_keywords') . '%');
				$query->orWhere('about_content', 'like', '%' . $filters->input('ad_keywords') . '%');
				$query->orWhere('about_project_content', 'like', '%' . $filters->input('ad_keywords') . '%');
			});
		}
		//Filter ads based on the role of the logged user
		if ($roleUser === 2) {
			$adsFiltred->whereHas('attributionAd', function (Builder $q) use ($roleUser) {
				$q->where('user_advisor_id', '=', auth()->id());
			});
		} else if ($roleUser === 3) {
			$supervisorLocationTerritoryCodes = $this->userService->getAllDepartmentsInSupervisorTerritory();
			$adsFiltred->where(function (Builder $query) use ($supervisorLocationTerritoryCodes) {
				$query->whereNotNull('project_id');
				$query->whereHas('attributionAd', function (Builder $q) {
					$q->where('user_supervisor_id', '=', auth()->id());
				});
				$query->orWhereHas('departments', function (Builder $query) use ($supervisorLocationTerritoryCodes) {
					$query->whereIn('code', $supervisorLocationTerritoryCodes);
				});
				$query->orWhereHas('cities', function (Builder $query) use ($supervisorLocationTerritoryCodes) {
					$query->whereIn('department_code', $supervisorLocationTerritoryCodes);
				});
			});
		}
		//Handling sort of research results
		if ($filters->has('order') && $filters->has('sort')) {
			if ($filters->input('sort') === 'date') {
				$adsFiltred->orderBy('created_at', $filters->input('order'));
			} else if ($filters->input('sort') === 'title') {
				$adsFiltred
					->orderBy($filters->input('sort'), $filters->input('order'));

			} else if ($filters->input('sort') === 'name') {
				$adsFiltred
					->join('users', 'users.id', '=', 'ads.user_pp_id')
					->orderBy('first_name', $filters->input('order'));

			} else if ($filters->input('sort') === 'project_statuses.name') {
				$adsFiltred
					->select('ads.*')
					->leftJoin('projects as p1', 'p1.id', '=', 'ads.project_id')
					->leftJoin('project_statuses', 'p1.project_status_id', '=', 'project_statuses.id')
					->orderBy('name', $filters->input('order'));
			}
		} else {
			$adsFiltred->orderByDesc('created_at');
		}
		$ads = $adsFiltred
			->with([
				'project',
				'userPp',
				'cities',
				'cities.department',
				'cities.department.region',
				'departments',
				'departments.region',
				'regions',
				'attributionAd',
				'landSeekAd',
				'landOfferAd',
				'jobOfferAd',
				'jobSeekAd'
			])
			->paginate(15);
		return $ads;
	}


	public function findAllAdsPublishedSinceDaysAndNotComplete(int $numberOfDays) : Collection
	{
		$adsPublishedSinceDays = $this->repository->findAllPublishedSinceDays($numberOfDays);

		$adsPublishedSinceDaysAndNotComplete = $adsPublishedSinceDays->mapWithKeys(function ($ad){
			if(is_null($ad['about_content']) || is_null($ad['about_project_content'] )|| isset($ad['documents'])){
				return [$ad['id']=> $ad];
			}
			return [];
		});

		return $adsPublishedSinceDaysAndNotComplete;
	}
}