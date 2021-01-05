<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ForceDomain {

    public function handle(Request $request, Closure $next)
    {
        if($request->getHost() !== parse_url(config('app.url'))["host"]) {
            return redirect()->secure(config('app.url').$request->getRequestUri());
        }

        return $next($request);
    }
}
