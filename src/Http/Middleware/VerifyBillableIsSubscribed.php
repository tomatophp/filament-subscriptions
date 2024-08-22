<?php

namespace TomatoPHP\FilamentSubscriptions\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyBillableIsSubscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user || $user->activePlanSubscriptions()->isEmpty()) {
            return redirect()->route('subscription.portal');
        }

        return $next($request);
    }
}
