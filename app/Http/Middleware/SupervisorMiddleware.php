<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class SupervisorMiddleware
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
		if (!auth()->check()) {
			return redirect()->route('login');
		} elseif (auth()->user()->role === 0) {
			abort(404);
		} else {
			if (auth()->user()->role < 3) {
				abort(403);
			} else {
				return $next($request);
			}
		}
	}
}
