<?php

namespace App\Http\Controllers\Researches;

use App\Http\Controllers\Controller;
use App\Listeners\SendResearchNotification;
use App\Notifications\ResearchNotification;
use App\Services\Researches\ResearchService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Notification;

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
		list($ads, $adType, $regions) = $this->researchService->index($request);

		return view('pages.researches', compact('ads', 'adType', 'regions'));
	}

	public function paginate($ads, $perPage = 5, $page = null)
	{
		$page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
		$ads = $ads instanceof Collection ? $ads : Collection::make($ads);

		return new LengthAwarePaginator($ads->forPage($page, $perPage), $ads->count(), $perPage, $page);
	}

	public function store(Request $request)
	{

		$research = $this->researchService->create($request);

		return redirect()->route('researches.show');

	}

	public function show()
	{
		$researches = $this->researchService->findAll();

		return view('pages.savedResearches.listSavedResearches', compact('researches'));
	}

	public function destroy(Request $request)
	{
		$this->researchService->destroy($request);
		$researches = $this->researchService->findAll();

		return back()->with('destroy', 'message');

	}

	public function notificationCreateAlert(Request $request)
	{
		$this->researchNotification->newAlertResearch($request->input('research'));
		return back()->with('success', 'message');
	}

}
