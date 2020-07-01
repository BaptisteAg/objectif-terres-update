<?php

namespace App\Http\Controllers\Moderators;

use App\Http\Controllers\Controller;
use App\Models\AdStatus;
use App\Models\City;
use App\Models\Department;
use App\Models\JobOfferType;
use App\Models\ProductionGenre;
use App\Models\ProjectStatus;
use App\Models\Region;
use App\Services\AttributionAds\AttributionAdsService;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;
use Illuminate\Http\Request;

class ModeratorController extends BaseController
{
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$request->session()->forget('_old_input');
		$request->session()->forget('moderator_dashboard_url');
		$vars = $this->getModeratorDashboardVars();
		$vars['attributionAds'] = $this->service->findAllByUserModeratorTerritories();
		return view('pages.moderator.index', $vars);

	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function show(Request $request)
	{
		$request->flash();
		$request->session()->put('moderator_dashboard_url', $request->all());
		$vars = $this->getModeratorDashboardVars();
		$vars['attributionAds'] = $this->service->showForModerators($request);
		return view('pages.moderator.index', $vars);

	}

	/**
	 * Moderator help area controller
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function help()
	{
		$users = json_encode($this->userService->findAllExceptPPAndLoggedUser());
		return view('pages.moderator.help', compact('users'));
	}


}