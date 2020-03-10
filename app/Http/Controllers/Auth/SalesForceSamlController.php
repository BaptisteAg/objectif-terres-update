<?php

namespace App\Http\Controllers\Auth;

use Aacotroneo\Saml2\Http\Controllers\Saml2Controller;
use Aacotroneo\Saml2\Saml2Auth;
use App\Services\Salesforce\SalesforceService;

class SalesForceSamlController extends Saml2Controller
{
    /**
     * @var SalesforceService
     */
    protected $salesForceService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SalesforceService $salesForceService)
    {
        $this->middleware('guest')->except('logout');
        $this->salesForceService = $salesForceService;
    }

    /**
     * @param Saml2Auth $saml2Auth
     * @return string|void|null
     * @throws \Exception
     */
    public function connexion()
    {
        // Get URLs
        $previousUrl = url()->previous();
        $urlBase = url()->to('/');

        // Set the previous url that we came from to redirect to after successful login but only if is internal
        if(($previousUrl != $urlBase . '/connexion') && (substr($previousUrl, 0, strlen($urlBase)) === $urlBase)) {
            session()->put('url.intended', $previousUrl);
        }

        return $this->salesForceService->login();
    }
}
