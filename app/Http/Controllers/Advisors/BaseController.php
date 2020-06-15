<?php


namespace App\Http\Controllers\Advisors;


use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\BioCertification;
use App\Models\JobOfferType;
use App\Models\ProductionGenre;
use App\Models\ProjectDataKey;
use App\Models\ProjectStatus;
use App\Models\ResponseTemplate;
use App\Models\SupportStage;
use App\Models\SupportState;
use App\Services\Ads\AdService;
use App\Services\Advisors\AdvisorsService;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;

abstract class BaseController extends Controller
{
	protected $advisorsService;
	protected $threadService;
	protected $userService;
	protected $adService;
	protected $adTypes;
	protected $adTypesFaIcons;

	public function __construct(AdvisorsService $advisorsService, ThreadService $threadService, UserService $userService, AdService $adService)
	{
		$this->advisorsService = $advisorsService;
		$this->threadService = $threadService;
		$this->adService = $adService;
		$this->userService = $userService;
		$this->adTypes = [
			['name' => 'Offre foncière', 'value' => 'landOfferAd'],
			['name' => 'Recherche foncière', 'value' => 'landSeekAd'],
			['name' => 'Offre d\'emploi', 'value' => 'jobOfferAd'],
			['name' => 'Recherche d\'emploi', 'value' => 'jobSeekAd'],
		];

		// TODO : remove ?
		$this->adTypesFaIcons = ["fa-home", "fa-home", "fa-universal-access", "fa-universal-access"];
	}

	/**
	 * Return all the vars needed to display advisors dashboard
	 * @return array
	 */
	protected function getAdvisorDashboardVars(): array
	{
		$supportStages = SupportStage::all();
		$supportStates = SupportState::all();
		$projectStatuses = ProjectStatus::all();
		$jobOfferTypes = JobOfferType::all();
		$productionGenres = ProductionGenre::all();
		$bioCertifications = BioCertification::all();
		$adTypes = $this->adTypes;
		$adTypesFaIcons = $this->adTypesFaIcons;
		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();
		$numberOfProjectToHandle = $this->advisorsService->findAllBySupportStageAndSupportState(SupportStage::FIRST_CONTACT_ID, SupportState::TO_HANDLE_ID)->count();



		return compact(
			'supportStages',
			'supportStates',
			'projectStatuses',
			'jobOfferTypes',
			'productionGenres',
			'bioCertifications',
			'adTypes',
			'adTypesFaIcons',
			'numberOfUnreadMessages',
			'numberOfProjectToHandle'
		);

	}

	/**
	 * @param Ad $ad
	 * @return array
	 */
	protected function getSupportDashboardVars(Ad $ad) : array
	{
		$supportStages = SupportStage::all();
		$supportStates = SupportState::all();
		$projectStatuses = ProjectStatus::all();
		$publicProjectDataKeys = ProjectDataKey::where('is_public', '=', 1)->with('projectDataValues')->get();
		$currentProjectKeyDataValues = $this->advisorsService->allNotesWithPublicProjectDatKeysByAdId($ad->id);
		$responseTemplates = ResponseTemplate::all();
		$listUserAds = $this->adService->findAllAdsByUser($ad->user_pp_id);

		return compact(
			'supportStages',
			'supportStates',
			'projectStatuses',
			'publicProjectDataKeys',
			'currentProjectKeyDataValues',
			'responseTemplates',
			'listUserAds'
		);

	}
}