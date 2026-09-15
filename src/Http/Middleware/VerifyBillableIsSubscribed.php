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
     * @param  Closure(Request):Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->activePlanSubscriptions()->isEmpty()) {
            if (filament()->getTenant()) {
                return redirect()->route('filament.'.filament()->getCurrentOrDefaultPanel()->getId().'.tenant.billing', ['tenant' => filament()->getTenant()->{filament()->getCurrentOrDefaultPanel()->getTenantSlugAttribute()}]);
            } else {
                return redirect()->route('filament.'.filament()->getCurrentOrDefaultPanel()->getId().'.tenant.billing');
            }
        }

        return $next($request);
    }
}
