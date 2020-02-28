<?php

namespace App\Providers;

use Aacotroneo\Saml2\Events\Saml2LoginEvent;
use App\Models\User;
use App\Services\Salesforce\SalesforceService;
use App\Services\Users\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class SalesforceServiceProvider extends ServiceProvider
{
    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var SalesforceService
     */
    protected $salesforceService;

    /**
     * SalesforceServiceProvider constructor.
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct($app)
    {
        parent::__construct($app);
        $this->userService = $app->make(UserService::class);
        $this->salesforceService = $app->make(SalesforceService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen('Aacotroneo\Saml2\Events\Saml2LoginEvent', function (Saml2LoginEvent $event) {

            $samlUser = $event->getSaml2User();

            // TODO: Implement preventing reuse of a $messageId to stop replay attacks
            $messageId = $event->getSaml2Auth()->getLastMessageId();
            //dd($samlUser->getAttributes());

            $email = $samlUser->getAttribute('email')[0];
            $sfId = $samlUser->getAttribute('userId')[0];

            /** @var User $user */
            $user = $this->userService->findByEmail($email);

            // Reverse user creation : if no user has been found, then we'll create it on the fly
            // to allow every salesforce-only user to pass the registration form
            if(!$user) {
                $salesforceUser = $this->salesforceService->findObject('User', $sfId);
                //dd($salesforceUser);

                $user = $this->userService->create([
                    'first_name' => $salesforceUser["FirstName"],
                    'name' => $salesforceUser["LastName"],
                    'email' => $email,
                    //'role'
                ]);
            }

            $user->sf_id = $samlUser->getUserId();
            $user->save();

            Auth::login($user);
        });

        Event::listen('Aacotroneo\Saml2\Events\Saml2LogoutEvent', function ($event) {
            Auth::logout();
            Session::save();
        });
    }
}
