<?php

namespace App\Http\Controllers\Auth;

use Aacotroneo\Saml2\Events\Saml2LoginEvent;
use Aacotroneo\Saml2\Http\Controllers\Saml2Controller;
use Aacotroneo\Saml2\Saml2Auth;
use App\Models\User;
use App\Services\Salesforce\SalesforceService;
use App\Services\Users\UserService;

class SalesForceSamlController extends Saml2Controller
{
    /**
     * @var SalesforceService
     */
    protected $salesforceService;
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SalesforceService $salesForceService, UserService $userService)
    {
        $this->middleware('guest')->except('logout');
        $this->salesforceService = $salesForceService;
        $this->userService = $userService;
    }

    /**
     * @param Saml2Auth $saml2Auth
     * @return string|void|null
     * @throws \Exception
     */
    public function connexion()
    {
        return $this->salesforceService->getLoginRedirect();
    }

    /**
     * Process an incoming saml2 assertion request.
     * Fires 'Saml2LoginEvent' event if a valid user is found.
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

        event(new Saml2LoginEvent($idpName, $samlUser, $saml2Auth));

        // TODO: Implement preventing reuse of a $messageId to stop replay attacks
        //$messageId = $event->getSaml2Auth()->getLastMessageId();
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

        if($user->sf_id != $sfId) {
            $user->sf_id = $sfId;
            $user->save();
        }

        //dd($user);
        //dd(session()->all());

        $intended = session('toto');

        auth()->login($user);

        session()->flash('success', "Vous avez bien été identifié.");

        logger("redirecting to intended :".$intended);
        if($intended) {
            return redirect($intended);
        }

        $redirectUrl = $samlUser->getIntendedUrl();

        if ($redirectUrl !== null) {
            return redirect($redirectUrl);
        } else {
            return redirect(config('saml2_settings.loginRoute'));
        }
    }
}
