<?php

namespace App\Http\Controllers\Ads;

use App\Http\Repositories\Ads\AdRepository;
use App\Http\Requests\Ads\AdRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ads\LandSeekAdRequest;

class AdsController extends Controller
{
    public function create()
	{
		return view('pages.ads.new');
	}

	public function store(AdRequest $request)
	{
        $data = $request->validated();

        if($data["ad_type"] === 'land_seek_ad') {
            return redirect()->action('AdsController@storeLandSeekAd');
        }

        return back()->withErrors('Aucun type d\'annonce correspondant.');
    }

	public function storeLandSeekAd(LandSeekAdRequest $request, AdRepository $repository)
    {
        $data = $request->validated();

        $ad = $repository->create($data);

        return redirect('/annonces/'.$ad->id);
    }
}
