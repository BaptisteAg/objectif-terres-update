<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\City;
use App\Models\User;
use App\Services\Ads\AdService;
use App\Services\Salesforce\SalesforceService;
use App\Services\Users\UserService;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    protected $adService;

    protected $userService;

    /**
     * UsersController constructor.
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
                'label' => $user->zipCode->name.' ('.$user->zipCode->zip_code.')',
                'value' => ['id' => $user->zipCode->id,
                    'name' => $user->zipCode->name,
                    'type' => 'cities',
                    'zip_code' => $user->zipCode->zip_code]];

            $user['citySelect'] = json_encode([$cityData]);
        }
        if ($user->formation) {
            $user['hasformation'] = true;
        }

        return view('pages.users.edit', compact('cities', 'user', 'isUserConnectedEditHisOwnAccount'));

    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request)
    {
        $data = $request->validated();

        if ((int) auth()->id() !== (int) $data['user_id']) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $user = User::where('email', '=', $data['email'])->first();

        if ($user !== null && $user->sf_id) {
            try {
                $this->salesforceService->updateContact($user->sf_id, $this->salesforceService::getOTUserToSalesforceContactMapping($data));
            } catch (\Exception $e) {
                \Log::warning('SF updateContact failed on profile update', [
                    'user_id' => $user->id,
                    'sf_id' => $user->sf_id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $this->userService->update($data);

        return redirect()->route('user.edit', $data['user_id'])->with('success', 'Mise à jour effectuée avec succès !');
    }
}
