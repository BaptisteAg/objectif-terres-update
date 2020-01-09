<?php

namespace App\Http\Controllers\Ads;

use App\Models\InstallationType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdsController extends Controller
{
    public function create()
	{
		$installationTypes = InstallationType::all();

		return view('pages.ads.new', compact('installationTypes'));
	}
	public function store(Request $request)
	{
//		return 'Le nom est ' . $request->input('nom');
		return view('pages.ads.new');
	}
}
