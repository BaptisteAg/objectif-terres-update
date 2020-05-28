<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdvisorMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param Request $request
	 * @param \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (!auth()->check()) {
			return redirect()->route('login');
		} elseif (auth()->user()->role === 0) {
			abort(404);
		} else {
			if (auth()->user()->role < 2) {
				return New Response(view('pages.errors.unauthorized')->with('role', 'primo-accueillants'));
			} else {
				return $next($request);
			}
		}
	}
}
