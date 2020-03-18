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
            $previousUrl = url()->current();
            $urlBase = url()->to('/');

            // Set the previous url that we came from to redirect to after successful login but only if is internal
            if(($previousUrl != $urlBase . '/connexion') && (substr($previousUrl, 0, strlen($urlBase)) === $urlBase)) {
                session()->put('url.intended', $previousUrl);
                session()->save();
            }

            return route('signIn');
        }
    }
}
