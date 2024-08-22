<?php

namespace TomatoPHP\FilamentSubscriptions\Providers;

use TomatoPHP\FilamentSubscriptions\Http\Middleware\VerifyBillableIsSubscribed;
use Closure;
use Exception;
use TomatoPHP\FilamentSubscriptions\Providers\Http\Middleware\VerifySparkBillableIsSubscribed;
use Filament\Billing\Providers\Contracts\Provider;
use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Spark\Spark;

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