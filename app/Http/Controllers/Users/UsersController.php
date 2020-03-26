<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Ads\AdService;

class UsersController extends Controller
{
	protected $adService;

	public function __construct(AdService $adService)
	{
		$this->adService = $adService;
	}

	public function show(User $user){

		if(auth()->user()->role <1){
			abort(404);
		}

		$ads = $this->adService->findAllByUser($user->id);

   	return view('pages.users.show', compact('ads', 'user'));
   }
}
