<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Rules\SalesforceUniqueEmail;
use App\Services\Salesforce\SalesforceService;
use App\Services\Users\UserService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class RegisterService
{
    /** @var UserService */
    protected $userService;

    /**
     * @var SalesforceService
     */
    private $salesforceService;

    /**
     * Create a new controller instance.
     */
    public function __construct(UserService $userService, SalesforceService $salesforceService)
    {
        $this->userService = $userService;
        $this->salesforceService = $salesforceService;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @throws \Throwable
     */
    public function create(array $data)
    {
        // dd($data);

        if ($data['city_id'] ?? $data['zip_code_id']) {
            try {
                $salesForceContact = $this->salesforceService->registerPP($data);
                $data['sf_id'] = $salesForceContact['id'];
            } catch (\Exception $e) {

            }
        }

        $user = $this->userService->create($data);

        if (! empty($data['sf_id'])) {
            $this->salesforceService->updateContact($data['sf_id'], [
                'OT_user_id__c' => $user->id,
            ]);
        }

        return $user;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data, $extraRules = [])
    {
        return Validator::make($data, array_merge([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string', 'email',
                'max:255',
                'unique:users',
                app(SalesforceUniqueEmail::class),
            ],
            'first_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'street' => ['nullable', 'string', 'min:5'],
            'civility' => ['required'],
            'profile' => ['required'],
            'city_id' => ['required'],

            'hasformation' => ['required_if:profile,1,2'],
            'formation' => ['required_if:hasformation,1'],
            'fromwhere' => ['required_if:profile,1,2'],
        ], $extraRules), [
            'city_id.required' => 'Veuillez sélectionner un lieu dans la liste en saisissant les premiers caractères',
        ]);
    }

    public function getVerifyUrl(User $user)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );
    }
}
