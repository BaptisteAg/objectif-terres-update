<?php

namespace App\Http\Controllers\Ads;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdsController extends Controller
{
    public function create()
	{
		return view('pages.ads.new');
	}
	public function store(Request $request)
	{
//		return 'Le nom est ' . $request->input('nom');
		return view('pages.ads.new');
	}
}
