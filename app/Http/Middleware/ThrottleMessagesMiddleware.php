<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

/**
 * Custom throttle middleware for messaging that exempts staff members.
 * Staff members (role >= 1) are exempt from rate limiting.
 */
class ThrottleMessagesMiddleware extends ThrottleRequests
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param int $maxAttempts
     * @param int $decayMinutes
     * @return mixed
     */
    public function handle($request, Closure $next, $maxAttempts = 1, $decayMinutes = 1, $prefix = '')
    {
        // Exempt staff members (role >= 1: moderators, advisors, supervisors, admins)
        if (auth()->check() && auth()->user()->role >= 1) {
            return $next($request);
        }

        // Apply rate limiting for regular users (porteurs de projet)
        return parent::handle($request, $next, $maxAttempts, $decayMinutes, $prefix);
    }

    /**
     * Create a 'too many attempts' exception.
     *
     * @param string $key
     * @param int $maxAttempts
     * @return \Illuminate\Http\Exceptions\ThrottleRequestsException
     */
    protected function buildException($key, $maxAttempts)
    {
        $retryAfter = $this->getTimeUntilNextRetry($key);

        $message = 'Vous devez attendre 1 minute avant d\'envoyer un nouveau message.';

        return new ThrottleRequestsException($message, null, [], $retryAfter);
    }
}
