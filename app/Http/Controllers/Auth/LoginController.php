<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Locations\LocationService;
use App\Services\Salesforce\SalesforceService;
use App\Services\Spip\SpipService;
use App\Services\Users\UserService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * This controller needs to exists because we never explicitly logout from salesforce
 *
 * Class LegacyLoginController
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function checkpoint(
        Request $request,
        SalesforceService $salesforceService,
        SpipService $spipService,
        UserService $userService
    ){
        if(!$request->has('email')) {
            return response()->json(['error' => "Email not provided"]);
        }

        $email = $request->get('email');

        if($userService->exists($email)) {
            return response()->json(['redirect' => false]);
        }

        if($spipService->userExists($email)) {
            return response()->json(['redirect' => false]);
        }

        if($salesforceService->emailExists($email, 'User')) {
            return response()->json(['redirect' => '/connexion/sso']);
        }

        return response()->json(['redirect' => false]);
    }

}
