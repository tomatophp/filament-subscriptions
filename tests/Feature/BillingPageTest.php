<?php

use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Laravelcm\Subscriptions\Models\Plan;
use Tests\Models\User;
use TomatoPHP\FilamentSubscriptions\Filament\Pages\Billing;
use TomatoPHP\FilamentSubscriptions\Http\Middleware\VerifyBillableIsSubscribed;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs($this->user = User::factory()->create());

    $this->basic = Plan::query()->create([
        'name' => 'Basic',
        'price' => 10,
        'currency' => 'USD',
        'invoice_period' => 1,
        'invoice_interval' => 'month',
        'trial_period' => 0,
        'trial_interval' => 'day',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $this->pro = Plan::query()->create([
        'name' => 'Pro',
        'price' => 20,
        'currency' => 'USD',
        'invoice_period' => 1,
        'invoice_interval' => 'month',
        'trial_period' => 0,
        'trial_interval' => 'day',
        'is_active' => true,
        'sort_order' => 2,
    ]);
});

it('subscribes a new user to the main plan and redirects to the panel url', function () {
    get(Billing::getUrl())->assertRedirect(Filament::getPanel('admin')->getUrl());

    expect($this->user->planSubscriptions()->count())->toBe(1)
        ->and(Plan::query()->where('slug', 'main')->exists())->toBeTrue();
});

it('renders the billing page for a subscribed user', function () {
    $this->user->newPlanSubscription('main', $this->basic);

    get(Billing::getUrl())
        ->assertSuccessful()
        ->assertSee('Basic')
        ->assertSee('Pro');
});

it('links back to the panel url, not the panel id', function () {
    $this->user->newPlanSubscription('main', $this->basic);

    $html = get(Billing::getUrl())->assertSuccessful()->getContent();

    expect($html)->toContain('href="'.Filament::getPanel('admin')->getUrl().'"')
        ->not->toContain('href="http://localhost/admin"');
});

it('changes the plan of the current subscription', function () {
    $this->user->newPlanSubscription('main', $this->basic);

    livewire(Billing::class)
        ->callAction('changePlanAction', arguments: ['plan' => ['id' => $this->pro->id]])
        ->assertRedirect(Filament::getPanel('admin')->getUrl());

    expect($this->user->planSubscriptions()->first()->plan_id)->toBe($this->pro->id);
});

it('cancels the current subscription', function () {
    $this->user->newPlanSubscription('main', $this->basic);

    livewire(Billing::class)->callAction('cancelPlanAction');

    expect($this->user->planSubscriptions()->first()->canceled())->toBeTrue();
});

it('sends users without an active subscription to the billing page', function () {
    Filament::setCurrentPanel(Filament::getPanel('admin'));

    $request = Request::create('/app');
    $request->setUserResolver(fn () => $this->user);

    $response = (new VerifyBillableIsSubscribed)->handle($request, fn () => response('through'));

    expect($response->getTargetUrl())->toBe(Billing::getUrl());
});

it('lets subscribed users through', function () {
    Filament::setCurrentPanel(Filament::getPanel('admin'));
    $this->user->newPlanSubscription('main', $this->basic);

    $request = Request::create('/app');
    $request->setUserResolver(fn () => $this->user);

    $response = (new VerifyBillableIsSubscribed)->handle($request, fn () => response('through'));

    expect($response->getContent())->toBe('through');
});
