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
        $username = env('API_DOC_USERNAME', 'api_admin');
        $password = env('API_DOC_PASSWORD');

        // Skip authentication in local development if no password is set
        if (app()->environment('local') && empty($password)) {
            return $next($request);
        }

        // Check HTTP Basic Auth credentials
        if ($request->getUser() !== $username || $request->getPassword() !== $password) {
            return response('Unauthorized', 401, [
                'WWW-Authenticate' => 'Basic realm="API Documentation"'
            ]);
        }

        return $next($request);
    }
}
