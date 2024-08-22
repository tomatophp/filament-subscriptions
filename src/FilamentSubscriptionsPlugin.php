<?php

namespace TomatoPHP\FilamentSubscriptions;

use TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\SubscriptionResource;
use Filament\Contracts\Plugin;
use Filament\Panel;


class FilamentSubscriptions implements Plugin
{
    public function getId(): string
    {
        return 'filament-pos';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            PlanResource::class,
            SubscriptionResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return new static();
    }
}