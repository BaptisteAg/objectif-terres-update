<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Salesforce\SalesforceService;
use App\Services\Users\UserService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
        UserService $userService
    ){
        if(!$request->has('email')) {
            return response()->json(['error' => "Email not provided"]);
        }

        $email = $request->get('email');

        if($salesforceService->emailExists($email, 'User')) {
            return response()->json(['redirect' => '/connexion/sso']);
        }

        if($userService->exists($email)) {
            return response()->json(['redirect' => false]);
        }

        return response()->json(['redirect' => false]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request, SalesforceService $salesforceService)
    {
        if($salesforceService->emailExists(auth()->user()->email, 'User')) {
            return redirect('/deconnexion/sso');
        }

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->loggedOut($request) ?: redirect('/');
    }
}
