<?php

use Laravelcm\Subscriptions\Models\Plan;

use function Pest\Laravel\artisan;

it('creates the main plan', function () {
    artisan('filament-subscriptions:install')
        ->expectsOutputToContain('Filament Subscription installed successfully.')
        ->assertSuccessful();

    expect(Plan::query()->where('slug', 'main')->count())->toBe(1);

    // Running it again keeps a single main plan.
    artisan('filament-subscriptions:install')->assertSuccessful();

    expect(Plan::query()->where('slug', 'main')->count())->toBe(1);
});
