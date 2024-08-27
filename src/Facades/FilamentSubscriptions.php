<?php

namespace TomatoPHP\FilamentSubscriptions\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use TomatoPHP\FilamentSubscriptions\Services\Contracts\Subscriber;

/**
 * @method static void register(Subscriber|array $author)
 * @method static Collection getOptions()
 * @method void afterSubscription(\Closure $closure)
 * @method void afterRenew(\Closure $closure)
 * @method void afterCanceling(\Closure $closure)
 * @method void afterChange(\Closure $closure)
 * @method \Closure getAfterSubscription()
 * @method \Closure getAfterRenew()
 * @method \Closure getAfterCanceling()
 * @method \Closure getAfterChange()
 */
class FilamentSubscriptions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filament-subscriptions';
    }
}
