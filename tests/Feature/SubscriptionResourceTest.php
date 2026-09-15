<?php

use Laravelcm\Subscriptions\Models\Plan;
use Laravelcm\Subscriptions\Models\Subscription;
use Tests\Models\User;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\SubscriptionResource;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\SubscriptionResource\Pages\ListSubscriptions;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs($this->user = User::factory()->create());

    $this->plan = Plan::query()->create([
        'name' => 'Basic',
        'price' => 10,
        'currency' => 'USD',
        'invoice_period' => 1,
        'invoice_interval' => 'month',
        'trial_period' => 0,
        'trial_interval' => 'day',
        'is_active' => true,
    ]);
});

it('renders the subscriptions page', function () {
    $this->user->newPlanSubscription('main', $this->plan);

    get(SubscriptionResource::getUrl('index'))->assertSuccessful();

    livewire(ListSubscriptions::class)
        ->assertSuccessful()
        ->assertCanSeeTableRecords(Subscription::query()->get());
});

it('creates a subscription from the list page', function () {
    $subscriber = User::factory()->create();

    livewire(ListSubscriptions::class)
        ->callAction('create', data: [
            'subscriber_type' => User::class,
            'subscriber_id' => $subscriber->id,
            'plan_id' => $this->plan->id,
            'use_custom_dates' => false,
        ])
        ->assertHasNoActionErrors();

    expect($subscriber->planSubscriptions()->count())->toBe(1)
        ->and($subscriber->planSubscriptions()->first()->plan_id)->toBe($this->plan->id);
});

it('cancels an active subscription', function () {
    $subscription = $this->user->newPlanSubscription('main', $this->plan);

    livewire(ListSubscriptions::class)
        ->callTableAction('cancel', $subscription)
        ->assertHasNoTableActionErrors();

    expect($subscription->refresh()->canceled())->toBeTrue()
        ->and($subscription->active())->toBeFalse();
});

it('renews an ended subscription', function () {
    $subscription = $this->user->newPlanSubscription('main', $this->plan);
    $subscription->forceFill([
        'starts_at' => now()->subMonths(2),
        'ends_at' => now()->subMonth(),
    ])->save();

    expect($subscription->refresh()->ended())->toBeTrue();

    livewire(ListSubscriptions::class)
        ->callTableAction('renew', $subscription)
        ->assertHasNoTableActionErrors();

    expect($subscription->refresh()->active())->toBeTrue()
        ->and($subscription->ends_at->isFuture())->toBeTrue()
        ->and($subscription->canceled_at)->toBeNull();
});
