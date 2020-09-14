<?php

namespace App\Http\Controllers\Advisors;


use App\Exports\Advisors\AdvisorsExport;
use App\Models\City;
use App\Models\CmsPage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
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

		$ads = $this->advisorsService->findAllSupportsByUserAdvisor(false);
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
		$users = json_encode($this->userService->findAllExceptPPAndLoggedUser());
		$pageContent = CmsPage::where('slug', 'like', '%'.'ressoures-primo-accueillant'. '%')->first();
		return view('pages.advisors.help', compact('users','pageContent'));
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
		$ad = $this->adService->findWithTrashedUser($adId);
		if (!$ad->project()->exists()) {
			abort(404);
		}
		$thread = $this->advisorsService->findSupportRequestThread($ad->id);
		if (!isset($thread) && auth()->id() === $ad->attributionAd->user_advisor_id) {
			$thread = $this->advisorsService->createSupportRequestThread($ad->id);
		}

		if (auth()->id() === $ad->attributionAd->user_advisor_id) {
			$thread = $this->advisorsService->findSupportRequestThread($ad->id);
			if (!isset($thread)) {
				$thread = $this->advisorsService->createSupportRequestThread($ad->id);
			}
		} else {
			if (isset($ad->attributionAd->user_advisor_id)) {
				$data = [
					'user_id' => $ad->attributionAd->user_advisor_id,
					'ad_id' => $ad->id,
				];
				$thread = $this->advisorsService->findThreadAdvisorInChargeOfSupportRequest($data);
			}
			$thread = null;

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
		ob_end_clean(); // this
		ob_start();
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
		if(!$request->has('project_data_key')){
			return back()->with('warning', 'Une erreur est survenue, veuillez réessayer');

		}
		$this->advisorsService->updateProjectDataKeysValues($request);
		return back()->with('success', 'L\'indicateur a bien été modifié');
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
