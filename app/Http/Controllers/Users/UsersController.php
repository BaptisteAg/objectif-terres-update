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
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
	protected $adService;
	protected $userService;

	/**
	 * UsersController constructor.
	 * @param AdService $adService
	 * @param UserService $userService
	 */
	public function __construct(AdService $adService, UserService $userService)
	{
		$this->adService = $adService;
		$this->userService = $userService;
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		return view('pages.users.index');
	}

	/**
	 * @param User $user
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show(User $user)
	{
		if (auth()->user()->role < 1) {
			abort(404);
		}
		$ads = $this->adService->findAllByUser($user->id);
		return view('pages.users.show', compact('ads', 'user'));
	}

	/**
	 * @param User $user
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit(User $user)
	{

		if (auth()->user()->role == 0) {
			if (auth()->user()->id != $user->id) {
				abort(404);
			}
		} elseif (auth()->user()->role < 2) {
			return New Response(view('pages.errors.unauthorized')->with('role', 'primo-accueillants'));
		} else {
			$cities = City::all();
			if ($user->zipCode) {
				$cityData = [
					'label' => $user->zipCode->name . " (" . $user->zipCode->zip_code . ")",
					'value' => ['id' => $user->zipCode->id,
						'name' => $user->zipCode->name,
						'type' => 'cities',
						'zip_code' => $user->zipCode->zip_code]];

				$user['citySelect'] = json_encode($cityData);
			}
			return view('pages.users.edit', compact('cities', 'user'));
		}
	}

	/**
	 * @param UserRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(UserRequest $request)
	{
		$data = $request->validated();
		$user = $this->userService->update($data);
		return redirect()->route('user.edit', $data['user_id'])->with('success', 'Votre profil a bien été mis à jour !');
	}
}
