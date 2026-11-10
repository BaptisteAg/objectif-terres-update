<?php

namespace App\Http\Controllers\Auth;

use Aacotroneo\Saml2\Http\Controllers\Saml2Controller;
use Aacotroneo\Saml2\Saml2Auth;
use App\Services\Salesforce\SalesforceService;
use Illuminate\Http\Request;

class SalesforceLoginController extends Saml2Controller
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
        $this->middleware('guest')->except(['salesforceLogout', 'sls']);
        $this->salesforceService = $salesForceService;
    }

    /**
     * Initiate a login request.
     *
     * @throws \Exception
     */
    public function salesforceLogin()
    {
        $saml2Auth = new Saml2Auth(Saml2Auth::loadOneLoginAuthFromIpdConfig('salesforce'));

        return $saml2Auth->login('/');
    }

    /**
     * Process an incoming saml2 assertion request.
     * This method is triggered right after a successful login
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     *
     * @throws \Throwable
     */
    public function acs(Saml2Auth $saml2Auth, $idpName)
    {
        $errors = $saml2Auth->acs();

        if (! empty($errors)) {
            logger()->error('Saml2 error_detail', ['error' => $saml2Auth->getLastErrorReason()]);
            session()->flash('saml2_error_detail', [$saml2Auth->getLastErrorReason()]);

            logger()->error('Saml2 error', $errors);
            session()->flash('saml2_error', $errors);

            if (config('app.env') === 'local') {
                throw new \Exception('Could not login : '.json_encode($errors));
            }

            return redirect('/connexion')->withErrors("Une erreur empêche l'identification depuis Salesforce. Merci de <a href='https://terredeliens.lightning.force.com/secur/logout.jsp' target='_blank'>cliquer ici</a> pour vous déconnecter de Salesforce, puis réessayez");
        }

        $samlUser = $saml2Auth->getSaml2User();

        // TODO: Implement preventing reuse of a $messageId to stop replay attacks
        // Problem : no expiration date is passed by salesforce
        $messageId = $saml2Auth->getLastMessageId();

        session()->put([
            'saml_session_index' => $samlUser->getSessionIndex(),
            'saml_name_id' => $samlUser->getNameId(),
        ]);

        $user = $this->salesforceService->getSyncedLocalUserFromSaml($samlUser);

        auth()->login($user);
        session()->flash('success', 'Vous avez bien été identifié.');

        $intended = session('url.intended');
        if ($intended) {
            return redirect($intended);
        }

        return redirect('/');
    }

    /**
     * Initiate a logout request across all the SSO infrastructure.
     *
     * @throws \OneLogin\Saml2\Error
     * @throws \Exception
     */
    public function salesforceLogout(Request $request)
    {
        $returnTo = route('saml2_sls', 'salesforce');
        $nameId = session('saml_name_id');
        $sessionIndex = session('saml_session_index');

        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $saml2Auth = new Saml2Auth(Saml2Auth::loadOneLoginAuthFromIpdConfig('salesforce'));

        return $saml2Auth->logout($returnTo, $nameId, $sessionIndex); // will actually end up in the sls endpoint
    }

    /**
     * Process an incoming saml2 logout request.
     * Disconnected from Salesforce, the user is then disconnected locally
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function sls(Saml2Auth $saml2Auth, $idpName)
    {
        $errors = $saml2Auth->sls($idpName, config('saml2_settings.retrieveParametersFromServer'));
        if (! empty($errors)) {
            logger()->error('Saml2 error', $errors);
            session()->flash('saml2_error', $errors);
            // throw new \Exception("Could not log out : ".json_encode($errors));
        }

        auth()->logout();
        session()->save();

        return redirect('/');
    }
}
