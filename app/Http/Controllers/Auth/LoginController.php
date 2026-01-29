<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Salesforce\SalesforceService;
use App\Services\Users\UserService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

/**
 * This controller needs to exist because we never explicitly logout from salesforce
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

        try {
            if($salesforceService->usernameExists($email, 'User')) {
                return response()->json(['redirect' => '/connexion/sso']);
            }
        } catch (\Exception $e) {
            // If Salesforce authentication fails, log the error and fall back to local authentication
            logger()->warning('Salesforce check failed during checkpoint', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
            // Fall through to local authentication check
        }

        if($userService->exists($email)) {
            return response()->json(['redirect' => false]);
        }

        return response()->json(['redirect' => false]);
    }

    public function testSalesforceConnection(Request $request)
    {
        // Vérifie si l'IP est autorisée
        if (!in_array($request->ip(), explode(',', env('DEBUG_IPS', '')))) {
            abort(404);
        }

        try {
            $status = [
                'env_check' => [
                    'SF_USERNAME' => !empty(env('SF_USERNAME')),
                    'SF_PASSWORD' => !empty(env('SF_PASSWORD')),
                    'SF_TOKEN' => !empty(env('SF_TOKEN')),
                    'SF_LOGIN_URL' => env('SF_LOGIN_URL'),
                ],
                'forrest_config' => config('forrest'),
            ];

            // Test de la connexion Salesforce
            try {
                \Omniphx\Forrest\Providers\Laravel\Facades\Forrest::authenticate();
                $status['salesforce_auth'] = 'Success';
            } catch (\Exception $e) {
                $status['salesforce_auth'] = [
                    'error' => $e->getMessage(),
                    'type' => get_class($e)
                ];
            }

            return response()->json($status);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request, SalesforceService $salesforceService)
    {
        $user = auth()->user();

        if($user) {
            try {
                if($salesforceService->usernameExists($user->email, 'User')) {
                    return redirect('/deconnexion/sso');
                }
            } catch (\Exception $e) {
                // If Salesforce authentication fails, log the error and proceed with local logout
                logger()->warning('Salesforce check failed during logout', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'error' => $e->getMessage()
                ]);
                // Fall through to local logout
            }
        }

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->loggedOut($request) ?: redirect('/');
    }
}
