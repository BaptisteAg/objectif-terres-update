<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Middleware\ThrottleRequests;

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
     * Create a 'too many attempts' exception with a French message.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $key
     * @param int $maxAttempts
     * @param callable|null $responseCallback
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function buildException($request, $key, $maxAttempts, $responseCallback = null)
    {
        $retryAfter = $this->getTimeUntilNextRetry($key);

        $exception = parent::buildException($request, $key, $maxAttempts, $responseCallback);

        // Override the message for a more user-friendly French response
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'rate_limit',
                'message' => 'Vous devez attendre 1 minute avant d\'envoyer un nouveau message.',
                'retry_after' => $retryAfter,
            ], 429);
        }

        return $exception;
    }
}
