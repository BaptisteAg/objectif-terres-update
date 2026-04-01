<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiDocBasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip if API doc auth is explicitly disabled
        if (config('apidoc.auth_enabled') === false) {
            return $next($request);
        }

        // Skip authentication in local development if no password is set
        if (app()->environment('local') && empty(config('apidoc.password'))) {
            return $next($request);
        }

        $username = config('apidoc.username');
        $password = config('apidoc.password');

        // Check if credentials are provided
        $providedUsername = $request->getUser();
        $providedPassword = $request->getPassword();

        // If no credentials provided or credentials are invalid, return 401 with WWW-Authenticate header
        if (empty($providedUsername) || empty($providedPassword) ||
            $providedUsername !== $username || $providedPassword !== $password) {

            $headers = ['WWW-Authenticate' => 'Basic realm="API Documentation"'];
            abort(401, 'Unauthorized', $headers);
        }

        return $next($request);
    }
}
