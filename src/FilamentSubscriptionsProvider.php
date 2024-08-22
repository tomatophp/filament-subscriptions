<?php

namespace TomatoPHP\FilamentSubscriptions\Providers;

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
            return redirect()->route('subscription.portal');
        };
    }

    public function getSubscribedMiddleware(): string
    {
        return VerifyBillableIsSubscribed::class;
    }
}