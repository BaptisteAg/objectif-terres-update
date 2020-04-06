<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Rules\SalesforceUniqueEmail;
use App\Services\Salesforce\SalesforceService;
use App\Models\City;
use App\Models\Country;
use App\Services\Users\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    /** @var UserService  */
	protected $userService;

    /**
     * @var SalesforceService
     */
    protected $salesForceService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService, SalesforceService $salesForceService)
    {
        $this->middleware('guest');
        $this->userService = $userService;
        $this->salesForceService = $salesForceService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
		return Validator::make($data, [
			'name' => ['required', 'string', 'max:255'],
			'email' => [
			    'required',
                'string', 'email',
                'max:255',
                'unique:users',
                app(SalesforceUniqueEmail::class)
            ],
			'first_name' => ['required', 'string', 'max:255'],
			'phone' => ['string', 'min:10', 'max:255'],
			'address' => ['string', 'min:5', 'required'],
			'civility' => ['required'],
			'profile' => ['required'],
			'country_id' => ['required'],
			'city_id' => ['required'],
            'password' => ['required', 'confirmed', 'min:5']
		], [
		    'city_id.required' => "Veuillez sélectionner un lieu dans la liste en saisissant les premiers caractères"
        ]);
	}

	/**
	 * Show the application registration form.
	 *
	 */
	public function showRegistrationForm()
	{
		$countries = Country::all();
		$cities = City::all();

		return view('auth.register', compact('countries', 'cities'));
	}


    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return redirect(session('url.intended', '/'));
    }

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param array $data
	 * @throws \Throwable
	 */
    protected function create(array $data)
    {
        //dd($data);
        $salesForceContact = $this->salesForceService->registerPP($data);
        $data["sf_id"] = $salesForceContact["id"];

		$user = $this->userService->create($data);
		return $user;
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
