<?php

namespace App\Http\Controllers\Ads;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\AdNote;
use App\Models\AdStatus;
use App\Models\AgriculturalActivity;
use App\Models\BioCertification;
use App\Models\BuildingType;
use App\Models\EducationLevel;
use App\Models\InstallationType;
use App\Models\JobOfferType;
use App\Models\OfferGenre;
use App\Models\ProjectDataKey;
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
	 * @param LocationService $locationService
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
     * @param Ad $ad
     * @return array
     * @throws \Exception
     */
    protected function getEditFormVars(Ad $ad): array
    {
        if (auth()->id() !== $ad->user_pp_id) {
            abort(404);
        }

        $selected_zones = json_encode(array_filter(array_merge(
            array_map($this->locationService->getResultRenderer('regions'), $ad->regions->toArray()),
            array_map($this->locationService->getResultRenderer('departments'), $ad->departments->toArray()),
            array_map($this->locationService->getResultRenderer('cities'), $ad->cities->toArray())
        )));
        $locationable = array_filter([
            "cities" => $ad->cities->pluck('id')->toArray(),
            "departments" => $ad->departments->pluck('id')->toArray(),
            "regions" => $ad->regions->pluck('id')->toArray()
        ]);
        $locationable_radius = $ad->cities->count() ? $ad->cities->first()->pivot->radius : '';


        $documents = $ad->documents->toJson();
        $document_ids = $ad->documents->pluck("id")->toArray();

        if (!is_null($ad->project_id)) {
            $vars = array_merge($this->getCreateFormVars(), [
                'isSupportRequest' => 1,
            ]);
        } else {
            $vars = $this->getCreateFormVars();
        }

        if (!old('ad_type')) {
            $vars["old"] = array_merge(
                [
                    'ad_type' => $this->adService->getAdType($ad),

                    'land_seek' => $ad->landSeekAd ?
                        array_merge($ad->landSeekAd->toArray(), [
                            "buildings" => $ad->landSeekAd->buildings->pluck("requirement.id", "buildingType.id")->toArray(),
                            "production_genres" => array_merge(
                                $ad->landSeekAd->productionGenres->pluck("id")->toArray(),
                                $ad->landSeekAd->production_type_add ? ['other'] : []
                            ),
                        ]) : null,

                    'land_offer' => $ad->landOfferAd ?
                        array_merge($ad->landOfferAd->toArray(), [
                            "bio_certifications" => $ad->landOfferAd->bioCertifications->pluck("id")->toArray(),
                            "production_genres" => array_merge(
                                $ad->landOfferAd->productionGenres->pluck("id")->toArray(),
                                $ad->landOfferAd->production_type_add ? ['other'] : []
                            ),
                            "production_genres_wanted" => array_merge(
                                $ad->landOfferAd->productionGenresPossible->pluck("id")->toArray(),
                                $ad->landOfferAd->production_type_wanted_add ? ['other'] : []
                            ),
                            "offer_genres" => $ad->landOfferAd->offerGenres->pluck("id")->toArray(),
                        ]) : null,

                    'job_offer' => $ad->jobOfferAd ?
                        array_merge($ad->jobOfferAd->toArray(), [
                            "offer_types" => $ad->jobOfferAd->jobOfferTypes->pluck("id")->toArray(),
                            "education_levels" => $ad->jobOfferAd->educationLevels->pluck("id")->toArray(),
                        ]) : null,

                    'job_seek' => $ad->jobSeekAd ?
                        array_merge($ad->jobSeekAd->toArray(), [
                            "offer_types" => $ad->jobSeekAd->jobOfferTypes->pluck("id")->toArray(),
                            "education_levels" => $ad->jobSeekAd->educationLevels->pluck("id")->toArray(),
                        ]) : null,
                ],
                $ad->only(["id", "title", "about_content", "about_project_content", "accept_share_contact_infos", "support_request_text"]),
                compact("selected_zones", "locationable", "locationable_radius", "documents", "document_ids")
            );
        }



        return $vars;
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

        if (empty($old["support_request_text"]) && session('support-request.text')) {
            $old["support_request_text"] = session('support-request.text');
        }

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
		$currentUser = auth()->user();
        $isSupportRequest = false;
		$allProjectDataKeys = [];
		$currentProjectKeyDataValues = [];

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

			if (is_null($ad->project)) {
				if (!empty($ad->attributionAd->adStatus) && $ad->attributionAd->adStatus->id === AdStatus::PENDING_MODERATION_STATUS_ID) {
					$isAdToModerate = true;
				}
			}else{
				$isSupportRequest = true;
				$allProjectDataKeys = ProjectDataKey::with('projectDataValues')->where('is_public', '=', 1)->get();
				$currentProjectKeyDataValues = AdNote::where('ad_id', '=', $ad->id)->whereNotNull('project_data_key_id')->get();
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
					if (isset($ad->support_request_territory_id)) {
						$advisorUsers = $this->userService->findByRolesAndTerritory([2, 3], $this->userService->getCurrentUserTerritoryIds());
					} else {
						$adDepartmentCodes = $this->adService->getAdDepartmentCodesFromZones($ad);
						$advisorUsers = $this->userService->findByRolesAndDepartments([2, 3], $adDepartmentCodes);
					}
				}
			}
			if ($user->role >= 1 && $ad->attributionAd && $ad->attributionAd->user_moderator_id !== $currentUser->id) {
				if (count(array_intersect($this->adService->getAdDepartmentCodesFromZones($ad), $this->userService->getCurrentUserTerritoryDepartments())) > 0) {
					$threads = $this->threadService->findThreadsByAd($ad->id);
				}
				if (isset($ad->support_request_territory_id)) {
					if (in_array($ad->support_request_territory_id, $this->userService->getCurrentUserTerritoryIds())) {
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
			'currentUser',
            'isSupportRequest',
			'allProjectDataKeys',
			'currentProjectKeyDataValues'
		);
	}
}
