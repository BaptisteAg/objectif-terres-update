<?php

namespace App\Http\Controllers\Supervisors;

use App\Exports\Supervisors\SupervisorsExport;
use App\Http\Controllers\Controller;
use App\Models\BioCertification;
use App\Models\CmsFaq;
use App\Models\CmsPage;
use App\Models\JobOfferType;
use App\Models\ProductionGenre;
use App\Models\ProjectDataKey;
use App\Models\ProjectStatus;
use App\Models\SupportStage;
use App\Models\SupportState;
use App\Services\Ads\AdService;
use App\Services\Projects\ProjectService;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class SupervisorsController extends BaseController
{

	/**
	 * @param Request $request
	 * @return Factory|View
	 */
	public function index(Request $request)
	{
		$request->session()->forget('_old_input');
		$request->session()->forget('moderator_dashboard_url');
		$request->session()->forget('supervisor_dashboard_url');
		if($request->input('toPaginate') === 'true'){
			$ads = $this->adService->findAllNotAssignedProjectsByUserSupervisor(true);
		}else{
			$ads = $this->adService->findAllNotAssignedProjectsByUserSupervisor(false);
		}
		$vars = $this->getSupervisorDashboardVars();
		$vars['ads'] = $ads;
		$vars['currentUser'] = auth()->user();
		return view('pages.supervisors.index', $vars);
	}


	/**
	 * @param Request $request
	 * @return Factory|View
	 */
	public function show(Request $request)
	{
		$request->flash();
		$request->session()->put('supervisor_dashboard_url', $request->all());
		$vars = $this->getSupervisorDashboardVars();
		$vars['ads'] = $this->adService->showForSupervisor($request);

		return view('pages.supervisors.index', $vars);
	}

	/**
	 * Supervisors help area controller
	 * @return Factory|View
	 */
	public function help()
	{
//		$users = json_encode($this->userService->findAllExceptPPAndLoggedUser());
//		$pageContents = CmsPage::where('slug', 'like', '%' . 'ressources-responsable-territorial' . '%')->with('documents')->get()->keyBy('slug');
//		return view('pages.supervisors.help', compact('users', 'pageContents'));
		return view('pages.supervisors.help');
	}

	/**
	 * Supervisor export data controller
	 * @param Request $request
	 * @return BinaryFileResponse
	 */
	public function export(Request $request)
	{
		if (is_null($request->input('date_from')) && is_null($request->input('date_from'))) {

			return (new SupervisorsExport($this->adService->findAllByUserSupervisor(false)))->download('export_tableau_de_bord_' . Carbon::now()->format('d_m_Y H-i-s') . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
		} else {
			$dates = [
				DateTime::createFromFormat('d/m/Y', (string)$request->input('date_from'))->format('Y-m-d'),
				DateTime::createFromFormat('d/m/Y', (string)$request->input('date_to'))->format('Y-m-d')
			];

			$ads = $this->adService->findAllByUserSupervisorBetweenDates($dates);
			return (new SupervisorsExport($ads))->download('export_tableau_de_bord_' . Carbon::now()->format('d_m_Y H-i-s') . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
		}
	}

	/**
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function attribute(Request $request)
	{
//		if (is_null($request->input('value'))) {
//			return back()->with('warning', 'Votre note est vide !');
//		}

		$this->projectService->attributeProject($request);
		return back()->with('success', 'La demande d\'accompagnement a bien été attribué !');
	}


	/**
	 * @return Factory|View
	 */
	public function report()
	{
		$ads = $this->adService->findAllAdsInSupervisorTerritories();
		$projects = $this->projectService->findAllProjectsInSupervisorTerritories();
		$vars = $this->getSupervisorReportVars($ads, $projects);
		return view('pages.supervisors.report', $vars);
	}


	/**
	 * @return Factory|View
	 */
	public function projectKeysDataEdit()
	{
		$allProjectDataKeys = ProjectDataKey::all();
		return view('pages.supervisors.project-data-keys-edit', compact('allProjectDataKeys'));
	}

	/**
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function projectDataKeysCreate(Request $request)
	{
		if (empty($request->input('project_data_key_name')) && empty($request->input('is_project_data_key_public'))) {
			return back()->with('error', 'Erreur dans la création d\'un nouvel indicateur, veuillez réessayer.');
		}
		$this->projectService->createProjectDataKey($request);
		return back()->with('success', 'La liste des indicateurs a bien été mise à jour !');
	}

	/**
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function projectDataKeyDelete(Request $request)
	{
		if (empty($request->input('project_data_key_id'))) {
			return back()->with('error', 'Aucun indicateur a été choisi');
		}
		$this->projectService->deleteProjectDataKey($request);
		return back()->with('success', 'La liste des indicateurs a bien été mise à jour !');
	}

}
