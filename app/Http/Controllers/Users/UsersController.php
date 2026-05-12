<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\User;
use App\Services\Ads\AdService;
use App\Services\Salesforce\SalesforceService;
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
	public function __construct(AdService $adService, UserService $userService, protected SalesforceService $salesforceService)
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
			abort(403);
		}

		if (auth()->user()->role >= 2) {
			$ads = $this->adService->findAttributedAndNotDraftedByUserId($user->id);
		} else {
			$ads = $this->adService->findAdsAttributedAndNotDraftedByUserId($user->id);
		}
		$currentUser = User::whereId(auth()->id())->first();

		return view('pages.users.show', compact('ads', 'user', 'currentUser'));
	}

	/**
	 * @param User $user
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit(User $user)
	{
		if (is_null($user) || $user->id !== auth()->user()->id && auth()->user()->role < 2) {
			abort(404);
		}
		$isUserConnectedEditHisOwnAccount = true;
		if (auth()->user()->id !== $user->id) {
			$isUserConnectedEditHisOwnAccount = false;
		}
		$cities = City::all();
		if ($user->zipCode) {
			$cityData = [
				'label' => $user->zipCode->name . " (" . $user->zipCode->zip_code . ")",
				'value' => ['id' => $user->zipCode->id,
					'name' => $user->zipCode->name,
					'type' => 'cities',
					'zip_code' => $user->zipCode->zip_code]];

			$user['citySelect'] = json_encode([$cityData]);
		}
        if($user->formation){
            $user['hasformation'] = true;
        }

		return view('pages.users.edit', compact('cities', 'user', 'isUserConnectedEditHisOwnAccount'));

	}

	/**
	 * @param UserRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(UserRequest $request)
	{
		$data = $request->validated();

        if((int) auth()->id() !== (int) $data['user_id']){
            abort(Response::HTTP_FORBIDDEN);
        }

        $user = User::where('email', '=', $data['email'])->first();

        if ($user !== null) {
            try {
                $this->salesforceService->updateContact($user->sf_id, $this->salesforceService::getOTUserToSalesforceContactMapping($data));
            }
            catch (\Exception $e) {
                // Do nothing
            }
        }

        $this->userService->update($data);
		return redirect()->route('user.edit', $data['user_id'])->with('success', 'Mise à jour effectuée avec succès !');
	}
}
