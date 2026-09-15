<?php

namespace TomatoPHP\FilamentSubscriptions;

use Closure;
use Filament\Billing\Providers\Contracts\BillingProvider;
use Illuminate\Http\RedirectResponse;
use TomatoPHP\FilamentSubscriptions\Http\Middleware\VerifyBillableIsSubscribed;

class FilamentSubscriptionsProvider implements BillingProvider
{
    /**
     * @return string | Closure | array<class-string, string>
     */
    public function getRouteAction(): string|Closure|array
    {
        return function (): RedirectResponse {
            if (filament()->getTenant()) {
                return redirect()->route('filament.'.filament()->getCurrentOrDefaultPanel()->getId().'.tenant.billing', ['tenant' => filament()->getTenant()->{filament()->getCurrentOrDefaultPanel()->getTenantSlugAttribute()}]);
            } else {
                return redirect()->route('filament.'.filament()->getCurrentOrDefaultPanel()->getId().'.tenant.billing');
            }
        };
    }

    public function getSubscribedMiddleware(): string
    {
        return VerifyBillableIsSubscribed::class;
    }
}
