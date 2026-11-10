<?php

namespace App\Http\Middleware;

use Closure;

class EnableDebugBarForIP
{
    public function handle(\Illuminate\Http\Request $request, Closure $next): mixed
    {
        if ($ips = config('debugbar.debug_ips')) {
            $ips = explode(',', $ips);

            if (in_array($request->ip(), $ips, true)) {
                // \Barryvdh\Debugbar\LaravelDebugbar::enable();
            }
        }

        return $next($request);
    }
}
