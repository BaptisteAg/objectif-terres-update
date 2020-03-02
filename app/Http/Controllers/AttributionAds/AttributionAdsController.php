<?php

namespace App\Http\Controllers\AttributionAds;

use App\Http\Controllers\Controller;
use App\Models\AttributionAd;
use App\Services\AttributionAds\AttributionAdsService;
use Illuminate\Http\Request;

class AttributionAdsController extends Controller
{
	protected $service;

	/**
	 * AttributionAdsController constructor.
	 * @param AttributionAdsService $service
	 */
	public function __construct(AttributionAdsService $service)
	{
		$this->service = $service;
	}

	/**
	 * @param Request $request
	 * @return array
	 */
	public function acceptAd(Request $request){
		$attributionAd = $this->service->acceptAd($request->input('attributionAdId'));
		return ['redirect'=> route('moderator.index')];

	}
}
