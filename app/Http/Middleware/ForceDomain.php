<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceDomain
{
    public function handle(Request $request, Closure $next)
    {

        // write the host to a file for debug
        file_put_contents(storage_path('logs/domain.txt'), $request->getHost());
        if ($request->getHost() !== parse_url(config('app.url'))['host']) {
            return redirect()->secure(config('app.url').$request->getRequestUri());
        }

        return $next($request);
    }
}
