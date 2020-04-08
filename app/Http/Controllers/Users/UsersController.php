<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\User;
use App\Services\Ads\AdService;
use App\Services\Users\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
	protected $adService;
	protected $userService;

	public function __construct(AdService $adService, UserService $userService)
	{
		$this->adService = $adService;
		$this->userService = $userService;
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

	public function edit(User $user)
	{
		if (auth()->user()->id != $user->id) {
			abort(404);
		}
		$cities = City::all();
		if ($user->zipCode) {
			$cityData = [
				'label' => $user->zipCode->name." (".$user->zipCode->zip_code.")",
				'value'=>['id' => $user->zipCode->id,
					'name' => $user->zipCode->name,
					'type' => 'cities',
					'zip_code' => $user->zipCode->zip_code]];

			$user['citySelect'] = json_encode($cityData);
		}
		return view('pages.users.edit', compact('cities', 'user'));
	}

	public function update(UserRequest $request)
	{
		$data = $request->validated();
		$user = $this->userService->update($data);
		return redirect()->route('user.edit', $data['user_id'])->with('success', 'Votre profil a bien été mis à jour !');
	}
}
