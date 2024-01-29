<?php

namespace App\Http\Controllers\Researches;

use App\Http\Controllers\Controller;
use App\Jobs\NotifyCreationAlertResearch;
use App\Models\EducationLevel;
use App\Models\InstallationType;
use App\Models\JobOfferType;
use App\Models\OfferGenre;
use App\Models\ProductionGenre;
use App\Models\Region;
use App\Models\Research;
use App\Services\Researches\ResearchService;
use Illuminate\Http\Request;

class ResearchesController extends Controller
{

    public function __construct(
        private ResearchService $researchService,
        private NotifyCreationAlertResearch $researchNotification
    )
    {
    }

    public function index(Request $request)
    {
        if ($request->has('ad_category')) {
            $selectedAdType = $request->input('ad_category');
        } else {
            return back()->withErrors([
                'error' => 'Aucune catégorie d\'annonce séléctionnée'
            ]);
        }

        $adsType = $request->get('ad_category');

        $ads = $this->researchService->index($request);

        $request->flash();

        $hasDepartmentPolygons = false;

        if (!empty($request->get("regions_location_researches_ids"))) {
            $regionIds = $request->get("regions_location_researches_ids");

            if (count($regionIds) === 1 && !$request->get("departments_location_researches_ids")) {
                $hasDepartmentPolygons = true;
            }
        }

        $searchedRegionNames = Region::whereIn('id', $request->get("regions_location_researches_ids") ?? [])->pluck('name')->toArray();
        $searchedTypeOfProductions = ProductionGenre::whereIn('id', $request->get("production_genres") ?? [])->pluck('name')->toArray();
        $searchedSurface = [
            'min' => $request->get('surfaces_research_min'),
            'max' => $request->get('surfaces_research_max')
        ];
        $transmissions = OfferGenre::whereIn('id', $request->get("offer_genres") ?? [])->pluck('name')->toArray();
        $waterAccess = match($request->get('water_access')) {
            '1' => 'Oui',
            '2' => 'Non',
            '-1' => 'Ne sait pas',
            default => null
        };
        $keywords = $request->get('keywords');
        $searchedPrice = [
            'min' => $request->get('price_min'),
            'max' => $request->get('price_max')
        ];
        $searchedRent = [
            'min' => $request->get('fermage_min'),
            'max' => $request->get('fermage_max')
        ];
        $installation = InstallationType::where('id', $request->get('installation'))->first()->name ?? null;
        $educationsSearched = $request->get('formations') ? EducationLevel::whereIn('id', $request->get('formations'))->pluck('name')->toArray() : [];
        $experiencesSearched = $request->get('experiences') ? JobOfferType::whereIn('id', $request->get('experiences'))->pluck('name')->toArray() : [];

		return view('pages.researches', compact(
            'ads', 'adsType', 'request', 'hasDepartmentPolygons',
            'searchedRegionNames', 'searchedTypeOfProductions', 'searchedSurface', 'transmissions',
            'waterAccess', 'keywords', 'searchedPrice', 'searchedRent', 'installation', 'educationsSearched', 'experiencesSearched'
        ));
	}

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $research = $this->researchService->create($request);

        return redirect()->route('researches.show');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $researches = $this->researchService->findAllByUser(auth()->user()->id);
        $numberAlertActives = 0;
        foreach ($researches as $research) {
            if ($research->has_alert === 1) {
                $numberAlertActives++;
            }
        }
        return view('pages.savedResearches.listSavedResearches', compact('researches', 'numberAlertActives'));
    }

    /**
     * @param Research $research
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Research $research)
    {
        if (auth()->id() !== $research->user_id) {
            abort(404);
        }
        $this->researchService->destroy($research);
        return back()->with('success', 'La recherche a bien été supprimée.');
    }

    /**
     * @param Research $research
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAlert(Research $research)
    {
        if (auth()->id() !== $research->user_id) {
            abort(404);
        }
        $this->researchService->deleteAlert($research);
        return back()->with('success', 'L\'alerte a bien été supprimée');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function notificationCreateAlert(Request $request)
    {
        $this->researchNotification->handle($request->input('research'));
        return back()->with('success', 'Une alerte a bien été créée. Un email de confirmation vous a été envoyé !');
    }

}
