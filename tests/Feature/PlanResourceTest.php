<?php

use Laravelcm\Subscriptions\Models\Plan;
use Tests\Models\User;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource\Pages\CreatePlan;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource\Pages\EditPlan;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource\Pages\ListPlans;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource\RelationManagers\FeatureManager;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs(User::factory()->create());

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

it('renders the plan pages', function () {
    get(PlanResource::getUrl('index'))->assertSuccessful();
    get(PlanResource::getUrl('create'))->assertSuccessful();
    get(PlanResource::getUrl('edit', ['record' => $this->plan]))->assertSuccessful();
});

it('lists the plans', function () {
    livewire(ListPlans::class)
        ->assertSuccessful()
        ->assertCanSeeTableRecords([$this->plan]);
});

it('creates a plan', function () {
    livewire(CreatePlan::class)
        ->fillForm([
            'name' => ['en' => 'Pro'],
            'currency' => 'USD',
            'price' => 25,
            'signup_fee' => 0,
            'invoice_interval' => 'month',
            'invoice_period' => 1,
            'trial_interval' => 'day',
            'trial_period' => 0,
            'is_active' => true,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $plan = Plan::query()->where('price', 25)->first();

    expect($plan)->not->toBeNull()
        ->and($plan->getTranslation('name', 'en'))->toBe('Pro');
});

it('edits a plan', function () {
    livewire(EditPlan::class, ['record' => $this->plan->getRouteKey()])
        ->fillForm(['price' => 15])
        ->call('save')
        ->assertHasNoFormErrors();

    expect((float) $this->plan->refresh()->price)->toBe(15.0);
});

it('manages the features of a plan', function () {
    livewire(FeatureManager::class, [
        'ownerRecord' => $this->plan,
        'pageClass' => EditPlan::class,
    ])
        ->assertSuccessful()
        ->callTableAction('create', data: [
            'name' => ['en' => 'Projects'],
            'value' => '10',
            'resettable_interval' => 'month',
            'resettable_period' => 1,
        ])
        ->assertHasNoTableActionErrors();

    expect($this->plan->features()->count())->toBe(1);
});

it('edits a translated feature', function () {
    $feature = $this->plan->features()->create([
        'name' => ['en' => 'Projects', 'ar' => 'مشاريع'],
        'value' => '10',
        'resettable_period' => 1,
        'resettable_interval' => 'month',
    ]);

    livewire(FeatureManager::class, [
        'ownerRecord' => $this->plan,
        'pageClass' => EditPlan::class,
    ])
        ->mountTableAction('edit', $feature)
        ->assertTableActionDataSet(['name' => ['en' => 'Projects', 'ar' => 'مشاريع', 'pt_BR' => '', 'my' => '', 'id' => '']])
        ->setTableActionData(['value' => '20'])
        ->callMountedTableAction()
        ->assertHasNoTableActionErrors();

    expect($feature->refresh()->value)->toBe('20')
        ->and($feature->getTranslation('name', 'ar'))->toBe('مشاريع');
});

it('fills the plan translations on the edit page', function () {
    $this->plan->setTranslation('name', 'ar', 'أساسي')->save();

    livewire(EditPlan::class, ['record' => $this->plan->getRouteKey()])
        ->assertSchemaStateSet(['name' => ['en' => 'Basic', 'ar' => 'أساسي', 'pt_BR' => '', 'my' => '', 'id' => '']]);
});
