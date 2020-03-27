<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class AdvisorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		if ($request->user() && $request->user()->role < 2){
			return New Response(view('pages.errors.unauthorized')->with('role', 'primo-accueillants'));
		}else {
			return $next($request);
		}
    }
}
