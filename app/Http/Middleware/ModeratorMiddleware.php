<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;


class ModeratorMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (!auth()->check() || auth()->user()->role === 0) {
			abort(404);
		} else {
			if (auth()->user()->role < 1) {
				return New Response(view('pages.errors.unauthorized')->with('role', 'modérateurs'));
			} else {
				return $next($request);
			}
		}
	}
}
