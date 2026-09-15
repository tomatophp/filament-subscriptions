<?php

use Filament\Facades\Filament;
use Filament\Panel;
use TomatoPHP\FilamentSubscriptions\Filament\Pages\Billing;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\SubscriptionResource;
use TomatoPHP\FilamentSubscriptions\FilamentSubscriptionsPlugin;

it('registers the billing page and the resources on the panel', function () {
    $panel = Filament::getPanel('admin');

    expect($panel->getPlugin('filament-subscriptions'))->toBeInstanceOf(FilamentSubscriptionsPlugin::class)
        ->and($panel->getPages())->toContain(Billing::class)
        ->and($panel->getResources())->toContain(PlanResource::class)
        ->and($panel->getResources())->toContain(SubscriptionResource::class);
});

it('can register the plugin without the resources', function () {
    $panel = Panel::make()->id('without-resources');

    FilamentSubscriptionsPlugin::make()->withoutResources()->register($panel);

    expect($panel->getPages())->toContain(Billing::class)
        ->and($panel->getResources())->toBeEmpty();
});

it('names the billing route after the panel', function () {
    expect(Billing::getRouteName(Filament::getPanel('admin')))->toBe('filament.admin.tenant.billing')
        ->and(Billing::getUrl())->toBe('http://localhost/app/billing');
});
