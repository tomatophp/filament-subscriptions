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

    public function getId(): string
    {
        return 'filament-subscriptions';
    }

    public function showUserMenu(bool $showUserMenu): static
    {
        $this->showUserMenu = $showUserMenu;
        return $this;
    }

    public function register(Panel $panel): void
    {
        $panel
            ->pages([
                Billing::class
            ])
            ->resources([
                PlanResource::class,
                SubscriptionResource::class,
            ]);

        if($this->showUserMenu){
            $panel->userMenuItems([
                MenuItem::make()
                    ->label('Manage Subscriptions')
                    ->icon('heroicon-s-banknotes')
                    ->url(url(config('filament-subscriptions.route')))
            ]);
        }
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
