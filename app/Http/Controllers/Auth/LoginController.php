<?php

namespace App\Http\Controllers\Auth;

use Aacotroneo\Saml2\Http\Controllers\Saml2Controller;
use Aacotroneo\Saml2\Saml2Auth;
use App\Services\Salesforce\SalesforceService;

class LoginController extends Saml2Controller
{
    /**
     * @var SalesforceService
     */
    protected $salesforceService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SalesforceService $salesForceService)
    {
        $this->middleware('guest')->except('logout');
        $this->salesforceService = $salesForceService;
    }

    /**
     * @param Saml2Auth $saml2Auth
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function preLogin()
    {
        return $this->salesforceService->getLoginRedirect();
    }

    /**
     * Process an incoming saml2 assertion request.
     * Fires 'Saml2LoginEvent' event if a valid user is found.
     *
     * This method is triggered right after a successful login
     *
     * @param Saml2Auth $saml2Auth
     * @param $idpName
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function acs(Saml2Auth $saml2Auth, $idpName)
    {
        $errors = $saml2Auth->acs();

        if (!empty($errors)) {
            logger()->error('Saml2 error_detail', ['error' => $saml2Auth->getLastErrorReason()]);
            session()->flash('saml2_error_detail', [$saml2Auth->getLastErrorReason()]);

            logger()->error('Saml2 error', $errors);
            session()->flash('saml2_error', $errors);
            return redirect(config('saml2_settings.errorRoute'));
        }

        $samlUser = $saml2Auth->getSaml2User();

        // TODO: Implement preventing reuse of a $messageId to stop replay attacks
        //$messageId = $event->getSaml2Auth()->getLastMessageId();
        //dd($samlUser->getAttributes());

		$user = $this->salesforceService->getUserFromSaml($samlUser);

        //dd($user);
        //dd(session()->all());

        auth()->login($user);
        session()->flash('success', "Vous avez bien été identifié.");

        $intended = session('url.intended');
        logger("redirecting to intended :".$intended);
        if($intended) {
            return redirect($intended);
        }

        return redirect('/');
    }
}
