<?php

namespace TomatoPHP\FilamentSubscriptions;

use Filament\Navigation\MenuItem;
use TomatoPHP\FilamentSubscriptions\Filament\Pages\Billing;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\SubscriptionResource;
use Filament\Contracts\Plugin;
use Filament\Panel;


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

    public function withoutResources(bool $withoutResources = true):static
    {
        $this->withoutResources = $withoutResources;
        return $this;
    }

    public function register(Panel $panel): void
    {
        $panel
            ->pages([
                Billing::class
            ]);

        if(!$this->withoutResources){
            $panel
                ->resources([
                    PlanResource::class,
                    SubscriptionResource::class,
                ]);
        }


    }

    public function boot(Panel $panel): void
    {
        if($this->showUserMenu && !filament()->hasTenancy()){
            $panel->userMenuItems([
                MenuItem::make()
                    ->label('Manage Subscriptions')
                    ->icon('heroicon-s-credit-card')
                    ->url(route('filament.' . $panel->getId() . '.tenant.billing'))
            ]);
        }
    }

    public static function make(): static
    {
        return new static();
    }
}
