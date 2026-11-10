<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // Get URLs
            $intendedUrl = url()->current();
            $urlBase = url()->to('/');

            // Set the previous url that we came from to redirect to after successful login but only if is internal
            if (($intendedUrl != $urlBase.'/connexion') && (substr($intendedUrl, 0, strlen($urlBase)) === $urlBase)) {

                $isSupportRequest =
                    $request->route()->getName() === 'support-request.create' &&
                    url()->previous() === url()->route('support-request.start');

                if ($isSupportRequest) {
                    session()->put('info',
                        'Afin de traiter au mieux votre demande nous avons besoin d’en savoir plus sur votre projet. 
                        Pour cela merci de vous connecter.'
                    );
                } else {
                    session()->put('info',
                        'Veuillez vous connecter pour accéder à cette page.'
                    );
                }

                session()->put('url.intended', $intendedUrl);
                session()->save();
            }

            return route('login');
        }
    }
}
