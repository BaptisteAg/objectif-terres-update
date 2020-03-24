<?php

namespace App\Http\Controllers\Researches;

use App\Models\Research;
use App\Http\Controllers\Controller;
use App\Listeners\SendResearchNotification;
use App\Services\Researches\ResearchService;
use Illuminate\Http\Request;


class ResearchesController extends Controller
{
	private $researchService;
	private $researchNotification;

	public function __construct(ResearchService $researchService, SendResearchNotification $researchNotification)
	{
		$this->researchService = $researchService;
		$this->researchNotification = $researchNotification;
	}

	public function index(Request $request)
	{

		list ($ads, $adsType) = $this->researchService->index($request);
		$request->flash();
		return view('pages.researches', compact('ads', 'adsType'));
	}

	public function store(Request $request)
	{

		$research = $this->researchService->create($request);

		return redirect()->route('researches.show');

	}

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

	public function destroy(Research $research)
	{
		if (auth()->id() !== $research->user_id) {
			abort(404);
		}
		$this->researchService->destroy($research);
		return back()->with('success', 'La recherche a bien été supprimée.');

	}

	public function deleteAlert(Research $research)
	{
		if (auth()->id() !== $research->user_id) {
			abort(404);
		}
		$this->researchService->deleteAlert($research);
		return back()->with('success', 'L\'alerte a bien été supprimée');

	}

	public function notificationCreateAlert(Request $request)
	{
		$this->researchNotification->newAlertResearch($request->input('research'));
		return back()->with('success', 'Une alerte a bien été créée. Un email de confirmation vous a été envoyé !');
	}

}
