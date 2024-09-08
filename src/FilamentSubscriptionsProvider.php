<?php

namespace TomatoPHP\FilamentSubscriptions;

use TomatoPHP\FilamentSubscriptions\Http\Middleware\VerifyBillableIsSubscribed;
use Closure;
use Filament\Billing\Providers\Contracts\Provider;
use Illuminate\Http\RedirectResponse;

class FilamentSubscriptionsProvider implements Provider
{
    /**
     * @return string | Closure | array<class-string, string>
     */
    public function getRouteAction(): string | Closure | array
    {
        return function (): RedirectResponse {
            if(filament()->getTenant()){
                return redirect()->route('filament.'.filament()->getCurrentPanel()->getId().'.tenant.billing', ['tenant'=> filament()->getTenant()->{filament()->getCurrentPanel()->getTenantSlugAttribute()}]);
            }
            else {
                return redirect()->route('filament.'.filament()->getCurrentPanel()->getId().'.tenant.billing');
            }
        };
    }

    public function getSubscribedMiddleware(): string
    {
        return VerifyBillableIsSubscribed::class;
    }
}
