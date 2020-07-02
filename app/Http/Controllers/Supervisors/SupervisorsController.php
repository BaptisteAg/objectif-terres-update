<?php

namespace App\Http\Controllers\Supervisors;

use App\Exports\Supervisors\SupervisorsExport;
use App\Http\Controllers\Controller;
use App\Models\BioCertification;
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
		$request->session()->forget('supervisor_dashboard_url');
		$ads = $this->adService->findAllNotAssignedProjectsByUserSupervisor(false);
		$vars = $this->getSupervisorDashboardVars();
		$vars['ads'] = $ads;

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
		$ads = $this->adService->showForSupervisor($request);
		$vars = $this->getSupervisorDashboardVars();
		$vars['ads'] = $ads;

		return view('pages.supervisors.index', $vars);
	}

	/**
	 * Supervisors help area controller
	 * @return Factory|View
	 */
	public function help()
	{
		$users = json_encode($this->userService->findAllExceptPPAndLoggedUser());
		return view('pages.supervisors.help', compact('users'));
	}

	/**
	 * Supervisor export data controller
	 * @param Request $request
	 * @return BinaryFileResponse
	 */
	public function export(Request $request)
	{
		if (is_null($request->input('date_from')) && is_null($request->input('date_from'))) {
			return Excel::download(new SupervisorsExport($this->adService->findAllByUserSupervisor(false)), 'export_tableau_de_bord_' . Carbon::now()->format('d_m_y') . '.xlsx');
		} else {
			$dates = [
				DateTime::createFromFormat('d/m/Y', (string)$request->input('date_from'))->format('Y-m-d'),
				DateTime::createFromFormat('d/m/Y', (string)$request->input('date_to'))->format('Y-m-d')
			];
			$ads = $this->adService->findAllByUserSupervisorBetweenDates($dates);
			return Excel::download(new SupervisorsExport($ads), 'export_tableau_de_bord_' . Carbon::now()->format('d_m_y') . '.xlsx');
		}
	}

	/**
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function attribute(Request $request)
	{
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
