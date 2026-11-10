<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdvisorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        } elseif (auth()->user()->role === 0) {
            abort(404);
        } else {
            if (auth()->user()->role < 2) {
                abort(403);
            } else {
                return $next($request);
            }
        }
    }
}
