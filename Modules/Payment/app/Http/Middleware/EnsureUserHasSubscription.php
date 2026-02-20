<?php

namespace Modules\Payment\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Allow if no user (guest) - let auth middleware handle authentication
        if (!$user) {
            return $next($request);
        }

        // Check if user has an active subscription
        if (!$user->subscribed()) {
            return redirect()->route('pricing')
                ->with('message', 'Please subscribe to access this feature.');
        }

        return $next($request);
    }
}
