<?php

namespace App\Http\Controllers\Advisors;


use App\Exports\Advisors\AdvisorsExport;
use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\AdNote;
use App\Models\BioCertification;
use App\Models\City;
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
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;


class AdvisorsController extends Controller
{
	protected $advisorsService;
	protected $threadService;
	protected $userService;
	protected $adService;
	protected $adTypes;
	protected $adTypesFaIcons;

	/**
	 * AdvisorsController constructor.
	 * @param AdvisorsService $advisorsService
	 * @param ThreadService $threadService
	 * @param UserService $userService
	 * @param AdService $adService
	 */
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
	 * @param Request $request
	 * @return Factory|View
	 */
	public function index(Request $request)
	{
		$request->session()->forget('_old_input');
		$supportStages = SupportStage::all();
		$supportStates = SupportState::all();
		$projectStatuses = ProjectStatus::all();
		$jobOfferTypes = JobOfferType::all();
		$productionGenres = ProductionGenre::all();
		$bioCertifications = BioCertification::all();
		$adTypes = $this->adTypes;
		$adTypesFaIcons = $this->adTypesFaIcons;

		$ads = $this->advisorsService->findAllSupportsByUserAdvisor(true);
		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();
		$numberOfProjectToHandle = $this->advisorsService->findAllBySupportStageAndSupportState(SupportStage::FIRST_CONTACT_ID, SupportState::TO_HANDLE_ID)->count();
		return view('pages.advisors.index', compact('supportStages', 'supportStates', 'projectStatuses', 'ads', 'jobOfferTypes', 'numberOfUnreadMessages', 'adTypes', 'adTypesFaIcons', 'numberOfProjectToHandle', 'productionGenres', 'bioCertifications'));
	}


	/**
	 * @param Request $request
	 * @return Factory|View
	 */
	public function show(Request $request)
	{
		$request->flash();

		$supportStages = SupportStage::all();
		$supportStates = SupportState::all();
		$projectStatuses = ProjectStatus::all();
		$jobOfferTypes = JobOfferType::all();
		$productionGenres = ProductionGenre::all();
		$bioCertifications = BioCertification::all();
		$adTypes = $this->adTypes;
		$adTypesFaIcons = $this->adTypesFaIcons;

		$ads = $this->advisorsService->showForAdvisor($request);
		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();
		$numberOfProjectToHandle = $this->advisorsService->findAllBySupportStageAndSupportState(SupportStage::FIRST_CONTACT_ID, SupportState::TO_HANDLE_ID)->count();
		return view('pages.advisors.index', compact('supportStages', 'supportStates', 'projectStatuses', 'jobOfferTypes', 'ads', 'numberOfUnreadMessages', 'adTypesFaIcons', 'adTypes', 'numberOfProjectToHandle', 'productionGenres', 'bioCertifications'));

	}

	/**
	 * Advisors help area controller
	 * @return Factory|View
	 */
	public function help()
	{
		$users = json_encode($this->userService->findAllExceptPPAndLoggedUser());
		return view('pages.advisors.help', compact('users'));
	}

	/**
	 * @return Factory|View
	 */
	public function registerNewUserPp()
	{
		$cities = City::all();
		return view('pages.advisors.register-new-user-pp', compact('cities'));
	}

	/**
	 * @param int $adId
	 * @return Factory|View
	 * @throws Throwable
	 */
	public function showSupport(int $adId)
	{
		$ad = $this->adService->find($adId);
		$responseTemplates = ResponseTemplate::all();
		$thread = $this->advisorsService->findSupportRequestThread($ad->id);
		$listUserAds = $this->adService->findAllAdsByUser($ad->user_pp_id);
		if (!isset($thread)) {
			$thread = $this->advisorsService->createSupportRequestThread($ad->id);
		}
		$supportStages = SupportStage::all();
		$supportStates = SupportState::all();
		$projectStatuses = ProjectStatus::all();
		$publicProjectDataKeys = ProjectDataKey::where('is_public', '=', 1)->get();
		$currentProjectKeyDataValues = $this->advisorsService->allNotesWithPublicProjectDatKeysByAdId($ad->id);

			if (!auth()->user()->unreadNotifications->isEmpty()) {
				$notifications = auth()->user()->unreadNotifications;
				foreach ($notifications as $notification){
					if(array_key_exists('ad_id', $notification->data) && $notification->data['ad_id'] === $ad->id){
						$notification->markAsRead();
						$notification->delete();
					}
				}
			}
		return view('pages.advisors.support-dashboard', compact('ad', 'responseTemplates', 'thread', 'listUserAds', 'supportStates', 'supportStages', 'projectStatuses', 'publicProjectDataKeys', 'currentProjectKeyDataValues'));
	}

	/**
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function updateSupport(Request $request)
	{
		$this->advisorsService->updateSupport($request->input());
		return back()->with('success', 'Le statut a bien été mis à jour !');
	}

	/**
	 * @return BinaryFileResponse
	 */
	public function export()
	{
		return Excel::download(new AdvisorsExport($this->advisorsService->findAllByUserAdvisor(false)), 'export_tableau_de_bord_' . Carbon::now()->format('d_m_y') . '.xlsx');
	}

	/**
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function createNote(Request $request)
	{
		if (is_null($request->input('value'))) {
			return back()->with('warning', 'Votre note est vide !');
		}
		$this->advisorsService->createNote($request);
		return back()->with('success', 'Votre note a bien été créée');
	}

	/**
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function editNote(Request $request)
	{
		$this->advisorsService->editNote($request->input());
		return back();
	}

	/**
	 * @param Request $request
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function deleteNote(Request $request)
	{
		$this->advisorsService->deleteNote($request);
		return back()->with('success', 'La note a été supprimée');
	}


	/**
	 * @param Request $request
	 * @return RedirectResponse
	 * @throws Throwable
	 */
	public function updateProjectDataKeysValues(Request $request){

		$this->advisorsService->updateProjectDataKeysValues($request);
		return back()->with('success', 'L\'indicateur a bien été modifié');
	}

	/**
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function uploadDocuments(Request $request)
	{
		if(($request->input('documents')) == '[]'){
			return back()->with('warning', 'Aucun document n\'a été déposé');
		}

		$this->advisorsService->uploadDocument($request->input());

		return back()->with('success', 'Votre document a bien été téléversé');
	}
}
