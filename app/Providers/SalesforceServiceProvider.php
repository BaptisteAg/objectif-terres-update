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
        Event::listen('Aacotroneo\Saml2\Events\Saml2LogoutEvent', function ($event) {
            Auth::logout();
            Session::save();
        });
    }
}
