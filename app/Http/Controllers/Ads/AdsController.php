<?php

namespace App\Http\Controllers\Ads;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Ads\AdRepository;
use App\Http\Requests\Ads\AdRequest;


class AdsController extends Controller
{
    public function create()
	{
		return view('pages.ads.new');
	}

	public function store(AdRequest $request, AdRepository $repository)
	{
        $data = $request->validated();

        dd($data);
        $ad = $repository->create($data);

        return redirect('/annonces/'.$ad->id);
    }
}
