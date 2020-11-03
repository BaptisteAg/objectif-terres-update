<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class RedirectIp {

    public function handle(Request $request, Closure $next)
    {
        if ($ips = config("app.filter_ips")) {
            $ips = explode(",", $ips);

            if(!in_array($request->ip(), $ips)) {
                return redirect('https://objectif-terres.org', 302);
            }
        }

        return $next($request);
    }
}
