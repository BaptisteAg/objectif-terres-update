<?php

namespace App\Http\Controllers\Supervisors;

use App\Exports\Supervisors\SupervisorsExport;
use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use App\Models\ProjectDataKey;
use App\Services\Users\UserService;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SupervisorsController extends BaseController
{
    /**
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $request->session()->forget('_old_input');
        $request->session()->forget('moderator_dashboard_url');
        $request->session()->forget('supervisor_dashboard_url');

        if ($request->input('toPaginate') === 'true' || $request->input('toPaginate') === null) {
            $ads = $this->adService->findAllNotAssignedProjectsByUserSupervisor(true);
        } else {
            $ads = $this->adService->findAllNotAssignedProjectsByUserSupervisor(false);
        }
        $vars = $this->getSupervisorDashboardVars();
        $vars['ads'] = $ads;
        $vars['currentUser'] = auth()->user();

        return view('pages.supervisors.index', $vars);
    }

    /**
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
     *
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
     *
     * @return BinaryFileResponse
     */
    public function export(Request $request)
    {
        if ($request->has('search')) {
            $ads = $this->adService->showForSupervisor($request);
        } else {
            $paginate = $request->input('toPaginate') === 'true' || $request->input('toPaginate') === null;
            $ads = $this->adService->findAllNotAssignedProjectsByUserSupervisor($paginate);
        }

        // Include soft-deleted ads with survey data in export
        $adIds = $ads->pluck('id')->toArray();
        $ads = \App\Models\Ad::withTrashed()
            ->whereIn('id', $adIds)
            ->orWhere(function ($query) {
                $query->withTrashed()
                    ->whereNotNull('survey_submitted_at')
                    ->whereNotNull('deleted_at');
            })
            ->with([
                'attributionAd',
                'attributionAd.adStatus',
                'attributionAd.userModerator',
                'userPp' => fn ($q) => $q->withTrashed(),
                'userPp.zipCode',
                'landSeekAd',
                'landOfferAd',
                'landOfferAd.productionGenres',
                'landOfferAd.productionGenresSecondary',
                'landOfferAd.bioCertifications',
                'landOfferAd.offerGenres',
                'jobOfferAd',
                'jobOfferAd.jobOfferTypes',
                'jobOfferAd.educationLevels',
                'jobSeekAd',
                'cities',
                'cities.department',
                'cities.department.region',
                'departments',
                'departments.region',
                'regions',
            ])
            ->get();

        return (new SupervisorsExport($ads))->download(
            'export_tableau_de_bord_'.Carbon::now()->format('d_m_Y H-i-s').'.xlsx',
            \Maatwebsite\Excel\Excel::XLSX
        );
    }

    /**
     * @return RedirectResponse
     */
    public function attribute(Request $request)
    {
        //		if (is_null($request->input('value'))) {
        //			return back()->with('warning', 'Votre note est vide !');
        //		}

        $hasSucceeded = $this->projectService->attributeProject($request);

        if (! $hasSucceeded) {
            return back()->withErrors("Il ne peut y avoir que 4 primo-accueillants par accompagnement. Veuillez d'abord désattribuer quelqu'un.");
        }

        return back()->with('success', 'La demande d\'accompagnement a bien été attribuée !');
    }

    public function deleteAttribution($adId, $slot)
    {
        $this->projectService->deleteAttribution($adId, $slot);

        return back()->with('success', 'L\'attribution a bien été supprimée !');
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
