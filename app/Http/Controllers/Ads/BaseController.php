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
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;
use Illuminate\Support\Facades\Auth;


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
	 * BaseController constructor.
	 * @param AdService $adService
	 * @param ThreadService $threadService
	 * @param FavoriteAdRepository $favoriteAdRepository
	 * @param UserService $userService
	 * @param AttributionAdsService $attributionAdService
	 */
	public function __construct(AdService $adService, ThreadService $threadService, FavoriteAdRepository $favoriteAdRepository, UserService $userService, AttributionAdsService $attributionAdService)
	{
		$this->adService = $adService;
		$this->threadService = $threadService;
		$this->favoriteAdRepository = $favoriteAdRepository;
		$this->userService = $userService;
		$this->attributionAdService = $attributionAdService;
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
			'requirements'
		);
	}

	/**
	 * Get all the vars needed to display an ad
	 *
	 * @param $adId
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
		$refusalTypes = '';
		$isAdToModerate = false;
		$isLoggedUserModeratorAd = false;
		$advisorUsers = [];

		/** @var User $user */
		$user = auth()->user();
        $moderatorInChargeOfModeration = false;
		if($user) {
            $moderatorInChargeOfModeration = $this->attributionAdService->moderatorIsChargeOfAdModeration($ad->id);
        }

		if ($user && $user->role >= 1 && $ad->is_draft != 1 ) {
			if ($ad->attributionAd->adStatus->id === AdStatus::PENDING_MODERATION_STATUS_ID) {
				$isAdToModerate = true;
			}
			if ($moderatorInChargeOfModeration) {
				$isLoggedUserModeratorAd = true;
				$responseTemplates = ResponseTemplate::all();
				$refusalTypes = RefusalType::all();
				//set to read if notification about moderation task about the ad exist
				if (!$user->unreadNotifications->isEmpty()) {
					$notification = $user->unreadNotifications()->where('data->ad_id', $ad->id)->first();
					if (!is_null($notification)) {
						$notification->markAsRead();
						$notification->delete();
					}
				}
			}
			if ($user->id === $ad->user_pp_id) {
				if ($user->role >= 2) {
					$responseTemplates = ResponseTemplate::all();
					if ($user->role >= 3) {
						$advisorUsers = $this->userService->findAllAdvisorsAndSupervisors();
					}
				}
				$threads = $this->threadService->findThreadsByAd($ad->id);
				$threadsWithUnreadMessages = $this->threadService->findThreadsByUnreadMessageAndAdId($ad->id);
			} else {
				if ($user->role >= 1) {
					$responseTemplates = ResponseTemplate::all();
					$refusalTypes = RefusalType::all();
				}
				if ($user->role >= 3) {
					//TODO display only advisors that are related to the supervisor
					$responseTemplates = ResponseTemplate::all();
					$advisorUsers = $this->userService->findAllAdvisorsAndSupervisors();
				}
				$threads = $this->threadService->findThreadAlreadyExist($user->id, $ad->id);
				$data = array(
					"ad_id" => $ad->id,
					"user_id" => $user->id,
				);
				$favoriteAdAlreadyExist = $this->favoriteAdRepository->findByUserAndAdId($data);
			}

		}

		return compact(
			'ad',
			'userMessage',
			'favoriteAdAlreadyExist',
			'threads',
			'threadsWithUnreadMessages',
			'responseTemplates',
			'refusalTypes',
			'isAdToModerate',
			'isLoggedUserModeratorAd',
			'advisorUsers'
		);
	}
}
