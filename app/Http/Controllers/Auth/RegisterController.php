<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\BasicNotification;
use App\Rules\SalesforceUniqueEmail;
use App\Services\Auth\RegisterService;
use App\Services\Salesforce\SalesforceService;
use App\Models\City;
use App\Models\Country;
use App\Services\Users\UserService;
use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Omniphx\Forrest\Exceptions\SalesforceException;

class RegisterController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/
	//use RegistersUsers;

	/**
	 * Where to redirect users after registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/';

    /**
     * @var RegisterService
     */
    private $registerService;


    /**
	 * Create a new controller instance.
	 *
	 * @param UserService $userService
	 */
	public function __construct(RegisterService $registerService)
	{
		$this->registerService = $registerService;
	}


	/**
	 * Show the application registration form.
	 *
	 */
	public function showRegistrationForm()
	{

		$cities = City::all();
		return view('auth.register', compact('cities'));
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
	 * @throws \Throwable
	 */
	public function register(Request $request)
	{
		$this->registerService->validator(
		    $request->all(),
            [
                'password' => ['required', 'confirmed', 'min:5']
            ]
        )->validate();
		try {
			event(new Registered($user = $this->registerService->create($request->all())));
			$this->guard()->login($user);
		} catch (SalesforceException $exception) {
			return back()->withInput()->withErrors(json_decode($exception->getMessage())[0]->message);
		}

        $user->notify(new BasicNotification([
            'subject' => "Bienvenue sur Objectif Terres !",
            'message' => "
                Vous venez de vous inscrire sur Objectif Terres pour réaliser votre projet agricole.\n
                Merci de confirmer votre email.",
            'action' => [
                "Confirmer mon email",
                $this->registerService->getVerifyUrl($user)
            ]
        ]));

		session()->flash('success', "Votre compte a été créé et nous vous avons identifié. Bienvenue !");

		return redirect(session('url.intended', '/'));
	}

	/**
	 * Get the guard to be used during registration.
	 *
	 * @return \Illuminate\Contracts\Auth\StatefulGuard
	 */
	protected function guard()
	{
		return Auth::guard();
	}
}
