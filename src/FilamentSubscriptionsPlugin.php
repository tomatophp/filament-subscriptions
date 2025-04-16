<?php

namespace TomatoPHP\FilamentSubscriptions;

use Filament\Navigation\MenuItem;
use Nwidart\Modules\Module;
use TomatoPHP\FilamentSubscriptions\Filament\Pages\Billing;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\SubscriptionResource;
use Filament\Contracts\Plugin;
use Filament\Panel;


class FilamentSubscriptionsPlugin implements Plugin
{
    public bool $showUserMenu = true;
    public bool $withoutResources = false;
    private bool $isActive = false;

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
        if (class_exists(Module::class) && \Nwidart\Modules\Facades\Module::find('FilamentSubscriptions')?->isEnabled()) {
            $this->isActive = true;
        } else {
            $this->isActive = true;
        }

        if ($this->isActive) {
            $panel
                ->pages([
                    config('filament-subscriptions.pages.billing', Billing::class)
                ]);

            if (!$this->withoutResources) {
                $panel
                    ->resources([
                        config('filament-subscriptions.resources.plan', PlanResource::class),
                        config('filament-subscriptions.resources.subscription', SubscriptionResource::class),
                    ]);
            }
        }
    }

    public function boot(Panel $panel): void
    {
        if ($this->isActive) {
            if ($this->showUserMenu && !filament()->hasTenancy()) {
                $panel->userMenuItems([
                    MenuItem::make()
                        ->label(trans('filament-subscriptions::messages.menu'))
                        ->icon('heroicon-s-credit-card')
                        ->url(
                            route(
                                'filament.' . $panel->getId() . '.tenant.billing',
                                // ['tenant'=> filament()->getTenant()->{filament()->getCurrentPanel()->getTenantSlugAttribute()}]
                            )
                        )
                ]);
            }
        }
    }

    public static function make(): static
    {
        return new static();
    }
}
