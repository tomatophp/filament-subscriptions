<?php

namespace TomatoPHP\FilamentSubscriptions;

use Filament\Contracts\Plugin;
use Filament\Navigation\MenuItem;
use Filament\Panel;
use TomatoPHP\FilamentSubscriptions\Filament\Pages\Billing;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\SubscriptionResource;

class FilamentSubscriptionsPlugin implements Plugin
{
    public bool $showUserMenu = true;

    public bool $withoutResources = false;

    public function getId(): string
    {
        return 'filament-subscriptions';
    }

    public function showUserMenu(bool $showUserMenu): static
    {
        $this->showUserMenu = $showUserMenu;

        return $this;
    }

    public function withoutResources(bool $withoutResources = true): static
    {
        $this->withoutResources = $withoutResources;

        return $this;
    }

    public function register(Panel $panel): void
    {
        $panel->pages([
            config('filament-subscriptions.pages.billing', Billing::class),
        ]);

        if (! $this->withoutResources) {
            $panel->resources([
                config('filament-subscriptions.resources.plan', PlanResource::class),
                config('filament-subscriptions.resources.subscription', SubscriptionResource::class),
            ]);
        }
    }

    public function boot(Panel $panel): void
    {
        if ($this->showUserMenu && ! $panel->hasTenancy()) {
            $panel->userMenuItems([
                MenuItem::make()
                    ->label(trans('filament-subscriptions::messages.menu'))
                    ->icon('heroicon-s-credit-card')
                    ->url(fn (): string => route('filament.'.$panel->getId().'.tenant.billing')),
            ]);
        }
    }

    public static function make(): static
    {
        return app(static::class);
    }
}
