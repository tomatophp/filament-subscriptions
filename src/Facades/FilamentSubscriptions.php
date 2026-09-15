<?php

namespace TomatoPHP\FilamentSubscriptions\Facades;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use TomatoPHP\FilamentSubscriptions\Services\Contracts\Subscriber;

/**
 * @method static void register(Subscriber|array $author)
 * @method static Collection getOptions()
 * @method static void afterSubscription(Closure $closure)
 * @method static void afterRenew(Closure $closure)
 * @method static void afterCanceling(Closure $closure)
 * @method static void afterChange(Closure $closure)
 * @method static Closure getAfterSubscription()
 * @method static Closure getAfterRenew()
 * @method static Closure getAfterCanceling()
 * @method static Closure getAfterChange()
 */
class FilamentSubscriptions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filament-subscriptions';
    }
}
