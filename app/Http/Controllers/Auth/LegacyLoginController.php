<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Salesforce\SalesforceService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

/**
 * This controller needs to exists because we never explicitly logout from salesforce
 *
 * Class LegacyLoginController
 * @package App\Http\Controllers\Auth
 */
class LegacyLoginController extends Controller
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

    /**
     * DEPRECATED : login happens externally by SSO
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    /*public function showLoginForm()
    {
        // Get URLs
        $previousUrl = url()->previous();
        $urlBase = url()->to('/');

        // Set the previous url that we came from to redirect to after successful login but only if is internal
        if (($previousUrl != $urlBase . '/connexion') && (substr($previousUrl, 0, strlen($urlBase)) === $urlBase)) {
            session()->put('url.intended', $previousUrl);
        }

        return view('auth.login');
    }*/

    /**
     * DEPRECATED
     *
     * @param Request $request
     * @param $user
     */
    public function authenticated(Request $request, $user)
    {
        session()->put('role', $user::ROLES[$user->role]);
    }
}
