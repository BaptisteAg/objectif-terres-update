<?php

namespace App\Http\Controllers\Ads;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\AgriculturalActivity;
use App\Models\BioCertification;
use App\Models\BuildingType;
use App\Models\EducationLevel;
use App\Models\InstallationType;
use App\Models\JobOfferType;
use App\Models\OfferGenre;
use App\Models\RefusalType;
use App\Models\Requirement;
use App\Models\ResponseTemplate;
use App\Models\SurfaceRange;
use App\Models\User;
use App\Repositories\FavoriteAds\FavoriteAdRepository;
use App\Services\Ads\AdService;
use App\Services\AttributionAds\AttributionAdsService;
use App\Services\Locations\LocationService;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;


abstract class BaseController extends Controller
{
	/** @var AdService */
	protected $adService;
	/** @var ThreadService */
	protected $threadService;
	/** @var FavoriteAdRepository */
	protected $favoriteAdRepository;
	/** @var UserService */
	protected $userService;
	/**
	 * @var AttributionAdsService
	 */
	protected $attributionAdService;
	/**
	 * @var LocationService
	 */
	protected $locationService;

	/**
	 * BaseController constructor.
	 * @param AdService $adService
	 * @param ThreadService $threadService
	 * @param FavoriteAdRepository $favoriteAdRepository
	 * @param UserService $userService
	 * @param AttributionAdsService $attributionAdService
	 */
	public function __construct(
		AdService $adService,
		ThreadService $threadService,
		FavoriteAdRepository $favoriteAdRepository,
		UserService $userService,
		AttributionAdsService $attributionAdService,
		LocationService $locationService
	)
	{
		$this->adService = $adService;
		$this->threadService = $threadService;
		$this->favoriteAdRepository = $favoriteAdRepository;
		$this->userService = $userService;
		$this->attributionAdService = $attributionAdService;
		$this->locationService = $locationService;
	}

	/**
	 * Returns all the vars needed to display an ad creation form
	 *
	 * @return array
	 */
	protected function getCreateFormVars(): array
	{
		$surfaceRanges = SurfaceRange::all();
		$installationTypes = InstallationType::all();
		$bioCertifications = BioCertification::all();
		$jobOfferTypes = JobOfferType::all();
		$offerGenres = OfferGenre::all();
		$agriculturalActivities = AgriculturalActivity::all();
		$educationLevels = EducationLevel::all();
		$buildingTypes = BuildingType::all();
		$requirements = Requirement::all();
		$productionGenres = $this->adService->getProductionGenresFlattened();
		$productionGenresWithOther = clone $this->adService->getProductionGenresFlattened()
			->concat([[
				'id' => 'other',
				'name' => 'Autre',
				'children' => []
			]]);
		$isSupportRequest = false;
		$old = old('ad_type') ? old() : [];

		return compact(
			'installationTypes',
			'surfaceRanges',
			'bioCertifications',
			'jobOfferTypes',
			'offerGenres',
			'educationLevels',
			'productionGenres',
			'productionGenresWithOther',
			'agriculturalActivities',
			'buildingTypes',
			'requirements',
			'isSupportRequest',
			"old"
		);
	}


	/**
	 * Get all the vars needed to display an ad
	 *
	 * @param Ad $ad
	 * @return array
	 *
	 * @throws \Exception
	 */
	protected function getShowVars(Ad $ad): array
	{
		$userMessage = null;
		$favoriteAdAlreadyExist = false;
		$threads = [];
		$threadsWithUnreadMessages = null;
		$responseTemplates = '';
		$isAdToModerate = false;
		$isLoggedUserModeratorAd = false;
		$advisorUsers = [];
		$moderatorInChargeOfModeration = false;
		$currentUser = User::whereId(auth()->id())->first();

		/** @var User $user */
		$user = auth()->user();
		if (isset($user)) {
			$moderatorInChargeOfModeration = $this->attributionAdService->moderatorIsChargeOfAdModeration($ad->id);
			$data = array(
				"ad_id" => $ad->id,
				"user_id" => $user->id,
			);
			$favoriteAdAlreadyExist = $this->favoriteAdRepository->findByUserAndAdId($data);
			$threads = $this->threadService->findThreadAlreadyExist($user->id, $ad->id);
			$threadsWithUnreadMessages = $this->threadService->findThreadsByUnreadMessageAndAdId($ad->id);
		}

		if ($user && $user->role >= 1) {
			$responseTemplates = ResponseTemplate::orderBy('title')->get();
			$threadsWithUnreadMessages = $this->threadService->findThreadsByUnreadMessageAndAdId($ad->id);

			if (!isset($ad->project)) {
				if (!empty($ad->attributionAd->adStatus) && $ad->attributionAd->adStatus->id === AdStatus::PENDING_MODERATION_STATUS_ID) {
					$isAdToModerate = true;
				}
			}
			if ($moderatorInChargeOfModeration) {
				$isLoggedUserModeratorAd = true;
				$responseTemplates = ResponseTemplate::orderBy('title')->get();
				$threads = $this->threadService->findThreadsByAd($ad->id);
				$threadsWithUnreadMessages = $this->threadService->findThreadsByUnreadMessageAndAdId($ad->id);
				//set to read if notification about moderation task about the ad exist
				if (!$user->unreadNotifications->isEmpty()) {
					$notification = $user->unreadNotifications()->where('data->ad_id', $ad->id)->first();
					if (!is_null($notification)) {
						$notification->markAsRead();
						$notification->delete();
					}
				}
			}
			if ($user->role >= 1) {
				$responseTemplates = ResponseTemplate::orderBy('title')->get();
			}
			if ($user->role >= 2) {
				$responseTemplates = ResponseTemplate::orderBy('title')->get();
				if ($user->role >= 3) {
					//TODO display only advisors that are related to the supervisor
					$responseTemplates = ResponseTemplate::orderBy('title')->get();
					if (isset($ad->support_request_id_region)) {
						$advisorUsers = $this->userService->findByRoleAndTerritory(2, $this->userService->getCurrentUserTerritoryIds());
					} else {
						$adDepartmentCodes = $this->adService->getAdDepartmentCodesFromZones($ad);
						$advisorUsers = $this->userService->findByRoleAndDepartments(2, $adDepartmentCodes);
					}
				}
			}
			if ($user->role >= 1 && $ad->attributionAd && $ad->attributionAd->user_moderator_id !== $currentUser->id) {
				if (count(array_intersect($this->adService->getAdDepartmentCodesFromZones($ad), $this->userService->getCurrentUserTerritoryDepartments())) > 0) {
					$threads = $this->threadService->findThreadsByAd($ad->id);
				}
				if (isset($ad->support_request_id_region)) {
					if (in_array($ad->support_request_id_region, $this->userService->getCurrentUserTerritoryIds())) {
						$threads = $this->threadService->findThreadsByAd($ad->id);
					}
				}
			}
		}
		return compact(
			'ad',
			'userMessage',
			'favoriteAdAlreadyExist',
			'threads',
			'threadsWithUnreadMessages',
			'responseTemplates',
			'isAdToModerate',
			'isLoggedUserModeratorAd',
			'advisorUsers',
			'moderatorInChargeOfModeration',
			'currentUser'
		);
	}
}
