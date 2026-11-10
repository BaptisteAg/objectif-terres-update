<?php

namespace App\Http\Middleware;

use Closure;

class ModeratorMiddleware
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
            return redirect()->route('login')->with('info', 'Vous devez être connecté pour accéder à cette page.');
        } elseif (auth()->user()->role === 0) {
            abort(404);
        } else {
            if (auth()->user()->role < 1) {
                abort(403);
            } else {
                return $next($request);
            }
        }
    }
}
