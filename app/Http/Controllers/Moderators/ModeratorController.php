<?php

namespace App\Http\Controllers\Moderators;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
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
        $request->session()->forget('supervisor_dashboard_url');
        $vars = $this->getModeratorDashboardVars();
        $vars['attributionAds'] = $this->service->findAllByUserModeratorTerritories();

        return view('pages.moderator.index', $vars);

    }

    /**
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
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function help()
    {
        //		$users = json_encode($this->userService->findAllExceptPPAndLoggedUser());
        //		$pageContents = CmsPage::where('slug', 'like', '%'.'ressources-moderateur'. '%')->with('documents')->get()->keyBy('slug');
        //		return view('pages.moderator.help', compact('users', 'pageContents'));
        return view('pages.moderator.help');
    }
}
