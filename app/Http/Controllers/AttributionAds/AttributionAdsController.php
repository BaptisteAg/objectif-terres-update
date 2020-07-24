<?php

namespace App\Http\Controllers\AttributionAds;

use App\Http\Controllers\Controller;
use App\Http\Requests\ThreadRequest;
use App\Models\AttributionAd;
use App\Models\Thread;
use App\Services\AttributionAds\AttributionAdsService;
use App\Services\Threads\ThreadService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttributionAdsController extends Controller
{
	protected $service;
	protected $threadService;


	/**
	 * AttributionAdsController constructor.
	 * @param AttributionAdsService $service
	 * @param ThreadService $threadService
	 */
	public function __construct(AttributionAdsService $service, ThreadService $threadService)
	{
		$this->service = $service;
		$this->threadService = $threadService;
	}

    /**
     * @param Request $request
     * @return array
     * @throws \Throwable
     */
	public function acceptAd(ThreadRequest $request)
	{
		$this->threadService->create($request->validated());
		$attributionAd = $this->service->acceptAd($request->input('attribution_ad_id'));
		$this->setToReadModeratorNotification($request->input('attribution_ad_id'));
		session()->flash('success', 'L\'annonce a été modérée !');
		return ['redirect' => route('moderator.index')];
	}

	/**
	 * @param ThreadRequest $request
	 * @return array
	 * @throws \Throwable
	 */
	public function modifyAd(ThreadRequest $request)
	{

		$this->threadService->create($request->validated());
		$attributionAd = $this->service->modifyAd($request->input('attribution_ad_id'));
		$this->setToReadModeratorNotification($request->input('attribution_ad_id'));
		session()->flash('success', 'L\'annonce a été modérée !');
		return ['redirect' => route('moderator.index')];

	}

	/**
	 * @param ThreadRequest $request
	 * @return array
	 * @throws \Throwable
	 */
	public function rejectAd(ThreadRequest $request)
	{
		$this->threadService->create($request->validated());

		$rejectAdData = [];
		$rejectAdData['attribution_ad_id'] = $request->input('attribution_ad_id');
		$rejectAdData['refusal_type_id'] = $request->input('refusal_type_id');
		$attributionAd = $this->service->rejectAd($rejectAdData);
		$this->setToReadModeratorNotification($request->input('attribution_ad_id'));
		session()->flash('success', 'L\'annonce a été modérée !');
		return ['redirect' => route('moderator.index')];

	}


	/**
	 * If exist, set to read and delete notification of ad not moderate since 7 days
	 * @param int $attributionAdsId
	 */
	private function setToReadModeratorNotification(int $attributionAdsId)
	{
		if (!auth()->user()->notifications->isEmpty()) {
			foreach ((auth()->user()->notifications) as $notification) {
				if ($notification->type === "App\Notifications\ModerationNotification") {
					$listOfAdsId = explode(' ', $notification->data['ads_id']);
					if (in_array($attributionAdsId, $listOfAdsId)) {
						$notification->markAsRead();
						$notification->delete();
					}
				}
			}
		}
	}
}