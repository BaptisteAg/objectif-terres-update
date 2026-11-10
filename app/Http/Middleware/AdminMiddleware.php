<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        } elseif (auth()->user()->role === 0) {
            abort(404);
        } else {
            if (auth()->user()->role < 4) {
                abort(403);
            } else {
                return $next($request);
            }
        }
    }
}
