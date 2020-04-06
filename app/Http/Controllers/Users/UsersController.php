<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\User;
use App\Services\Ads\AdService;

class UsersController extends Controller
{
	protected $adService;

	public function __construct(AdService $adService)
	{
		$this->adService = $adService;
	}

	public function index()
	{
		return view('pages.auth.index');

	}

	public function show(User $user)
	{
		if (auth()->user()->role < 1) {
			abort(404);
		}
		$ads = $this->adService->findAllByUser($user->id);
		return view('pages.users.show', compact('ads', 'user'));
	}

	public function update(){
		$countries = Country::all();
		$cities = City::all();
		$user = auth()->user();
		return view('pages.users.update', compact('cities', 'countries', 'user'));
	}
}
