<?php

namespace App\Http\Controllers\Advisors;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\JobOfferType;
use App\Models\ProjectStatus;
use App\Services\Advisors\AdvisorsService;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;
use Illuminate\Http\Request;


class AdvisorsController extends Controller
{
	protected $service;
	protected $threadService;
	protected $userService;
	protected $adTypes;
	protected $adTypesFaIcons;

	/**
	 * AdvisorsController constructor.
	 * @param AdvisorsService $advisorsService
	 * @param ThreadService $threadService
	 * @param UserService $userService
	 */
	public function __construct(AdvisorsService $advisorsService, ThreadService $threadService, UserService $userService)
	{
		$this->service = $advisorsService;
		$this->threadService = $threadService;
		$this->userService = $userService;
		$this->adTypes = [
			['name' => 'Offre foncière', 'value' => 'landOfferAd'],
			['name' => 'Recherche foncière', 'value' => 'landSeekAd'],
			['name' => 'Offre d\'emploi', 'value' => 'jobOfferAd'],
			['name' => 'Recherche d\'emploi', 'value' => 'jobSeekAd'],
		];
		$this->adTypesFaIcons = ["fa-home", "fa-home", "fa-universal-access", "fa-universal-access"];
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$request->session()->forget('_old_input');
		$projectStatuses = ProjectStatus::all();
		$jobOfferTypes = JobOfferType::all();
		$adTypes = $this->adTypes;
		$adTypesFaIcons = $this->adTypesFaIcons;

		$ads = $this->service->findAllByUserAdvisor();
		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();
		$numberOfNewProject = 3;

		return view('pages.advisors.index', compact(  'projectStatuses', 'ads', 'jobOfferTypes', 'numberOfUnreadMessages', 'adTypes', 'adTypesFaIcons', 'numberOfNewProject'));
	}


	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show(Request $request)
	{
		$request->flash();

		$projectStatuses = ProjectStatus::all();
		$jobOfferTypes = JobOfferType::all();
		$adTypes = $this->adTypes;
		$adTypesFaIcons = $this->adTypesFaIcons;

		$ads = $this->service->showForAdvisor($request);
		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();
		$numberOfNewProject = 3;
		return view('pages.advisors.index', compact( 'projectStatuses',  'jobOfferTypes', 'ads', 'numberOfUnreadMessages', 'numberOfAdsToModerate', 'adTypesFaIcons', 'adTypes', 'numberOfNewProject'));

	}

	/**
	 * Advisors help area controller
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function help()
	{
		$users = json_encode($this->userService->findAllExceptPPAndLoggedUser()) ;
		return view('pages.advisors.help', compact('users'));
	}


	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function registerNewUserPp()
	{
		$cities = City::all();
		return view('pages.advisors.register-new-user-pp', compact('cities'));
	}
}
