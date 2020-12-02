<?php

namespace App\Http\Controllers\Advisors;


use App\Exports\Advisors\AdvisorsExport;
use App\Models\City;
use App\Models\User;
use App\Notifications\BasicNotification;
use App\Services\Auth\RegisterService;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Omniphx\Forrest\Exceptions\SalesforceException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;


class AdvisorsController extends BaseController
{
	/**
	 * @param Request $request
	 * @return Factory|View
	 */
	public function index(Request $request)
	{
		$request->session()->forget('_old_input');
		$request->session()->forget('advisor_dashboard_url');
		if($request->input('toPaginate') === 'true'){
			$ads = $this->advisorsService->findAllSupportsByUserAdvisor(true);
		}else{
			$ads = $this->advisorsService->findAllSupportsByUserAdvisor(false);
		}
		$vars = $this->getAdvisorDashboardVars();
		$vars['ads'] = $ads;
		return view('pages.advisors.index', $vars);
	}


	/**
	 * @param Request $request
	 * @return Factory|View
	 */
	public function show(Request $request)
	{
		$request->flash();
		$request->session()->put('advisor_dashboard_url', $request->all());
		$ads = $this->advisorsService->showForAdvisor($request);
		$vars = $this->getAdvisorDashboardVars();
		$vars['ads'] = $ads;
		return view('pages.advisors.index', $vars);

	}

	/**
	 * Advisors help area controller
	 * @return Factory|View
	 */
	public function help()
	{
//		$users = json_encode($this->userService->findAllExceptPPAndLoggedUser());
//		$pageContents = CmsPage::where('slug', 'like', '%' . 'ressources-primo-accueillant' . '%')->with('documents')->get()->keyBy('slug');
//		return view('pages.advisors.help', compact('users', 'pageContents'));
		return view('pages.advisors.help');
	}

	/**
	 * @return Factory|View
	 */
	public function createNewUserPp()
	{
		$cities = City::all();
		return view('pages.advisors.register-new-user-pp', compact('cities'));
	}

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function registerNewUserPp(Request $request, RegisterService $registerService)
    {
        $data = $request->all();

        $data["password"] = Str::random(8);

        $registerService->validator($data)->validate();

        try {
            event(new Registered($user = $registerService->create($data)));
            auth()->login($user);
        } catch (SalesforceException $exception) {
            return back()->withInput()->withErrors(json_decode($exception->getMessage())[0]->message);
        }

        $user->notify(new BasicNotification([
            'subject' => "Bienvenue sur Objectif Terres !",
            'message' => "
                Vous avez été inscrit sur Objectif Terres par un primo-accueillant pour réaliser votre projet agricole.\n
                
                Le mot de passe généré pour vous est le suivant : ".$data["password"]."\n
                Utilisez-le pour vous connecter sur le site. Vous pourrez ensuite le modifier.\n\n
                
                Merci de confirmer votre email.",
            'action' => [
                "Confirmer mon email",
                $registerService->getVerifyUrl($user)
            ]
        ]));

        session()->flash('success', "Le compte PP a bien été créé.");

        return redirect('/');
    }

	/**
	 * @param int $adId
	 * @return Factory|View
	 * @throws Throwable
	 */
	public function showSupport(int $adId)
	{
		$ad = $this->adService->findWithTrashedUser($adId);
		if (!$ad->project()->exists()) {
			abort(404);
		}
//		$thread = $this->threadService->findSupportRequestThread($ad->id);
//		if (!isset($thread) && auth()->id() === $ad->attributionAd->user_advisor_id) {
//			$thread = $this->threadService->createSupportRequestThread($ad->id);
//		}

		if (auth()->id() === $ad->attributionAd->user_advisor_id) {
			$thread = $this->threadService->findSupportRequestThread($ad->id);
			if (!isset($thread)) {
				$thread = $this->threadService->createSupportRequestThread($ad->id, auth()->id());
			}
		} else {
			if (isset($ad->attributionAd->user_advisor_id)) {
				$data = [
					'user_id' => $ad->attributionAd->user_advisor_id,
					'ad_id' => $ad->id,
				];
				$thread = $this->advisorsService->findThreadAdvisorInChargeOfSupportRequest($data);
			} else {
				$thread = null;
			}
		}
		$this->advisorsService->handleSupportDashboardNotifications($ad);
		$vars = $this->getSupportDashboardVars($ad);
		$vars['ad'] = $ad;
		$vars['thread'] = $thread;
		return view('pages.advisors.support-dashboard', $vars);
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
	 * @param Request $request
	 * @return BinaryFileResponse
	 * @throws \PhpOffice\PhpSpreadsheet\Exception
	 * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
	 */
	public function export()
	{
		return (new AdvisorsExport($this->advisorsService->showForAdvisor(new Request())))->download('export_tableau_de_bord_' . Carbon::now()->format('d_m_Y H-i-s') . '.xlsx');
//		return Excel::download(new AdvisorsExport($this->advisorsService->showForAdvisor(new Request())), 'export_tableau_de_bord_' . Carbon::now()->format('d_m_Y H-i-s') . '.xlsx');
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
	public function updateProjectDataKeysValues(Request $request)
	{
		if (!$request->has('project_data_key')) {
			return back()->with('warning', 'Une erreur est survenue, veuillez réessayer');

		}
		$this->adService->updateProjectDataKeysValues($request);
		return back()->with('success', 'Les indicateurs ont bien été modifiés.');
	}

	/**
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function uploadDocuments(Request $request)
	{
		if (($request->input('documents')) == '[]') {
			return back()->with('warning', 'Aucun document n\'a été déposé');
		}

		$this->advisorsService->uploadDocument($request->input());

		return back()->with('success', 'Vos documents ont bien été téléversés');
	}

	/**
	 * @param User $user
	 * @return RedirectResponse
	 */
	public function blockUser(Request $request)
	{
		$this->advisorsService->blockUser($request->input('user_pp_id'));
		return back()->with('success', 'L\'utilisateur a bien été bloqué');
	}
}
