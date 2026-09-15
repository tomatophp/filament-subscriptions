{{-- Plain CSS scoped to this page: Filament 5 panels do not ship arbitrary Tailwind utility classes. --}}
<div class="fi-subscriptions-billing">
    <style>
        .fi-subscriptions-billing { display: grid; grid-template-columns: minmax(0, 18rem) minmax(0, 1fr); gap: 2rem; width: 100%; max-width: 76rem; margin: 0 auto; padding: 1.5rem 1rem 3rem; }
        @media (max-width: 64rem) { .fi-subscriptions-billing { grid-template-columns: minmax(0, 1fr); } }
        .fi-subscriptions-billing-aside { display: flex; flex-direction: column; gap: .75rem; }
        .fi-subscriptions-billing-brand { display: flex; align-items: center; gap: .75rem; font-size: 1.5rem; font-weight: 700; }
        .fi-subscriptions-billing-title { font-size: 1.125rem; font-weight: 600; }
        .fi-subscriptions-billing-muted { color: var(--gray-500); font-size: .875rem; line-height: 1.5; }
        .fi-subscriptions-billing-main { display: flex; flex-direction: column; gap: 1.5rem; }
        .fi-subscriptions-billing-plans { display: grid; grid-template-columns: repeat(auto-fill, minmax(16rem, 1fr)); gap: 1rem; }
        .fi-subscriptions-billing-price { font-size: 1.875rem; font-weight: 700; }
        .fi-subscriptions-billing-features { display: flex; flex-direction: column; gap: .5rem; margin-top: 1.25rem; font-size: .875rem; }
        .fi-subscriptions-billing-feature { display: flex; align-items: center; gap: .5rem; }
        .fi-subscriptions-billing-notice { padding: 1rem; margin-bottom: 1rem; border-radius: .5rem; background: var(--gray-100); color: var(--gray-700); font-size: .875rem; }
        .dark .fi-subscriptions-billing-notice { background: var(--gray-800); color: var(--gray-300); }
    </style>

    <aside class="fi-subscriptions-billing-aside">
        <div class="fi-subscriptions-billing-brand">
            <x-filament-panels::logo />
        </div>
        <div class="fi-subscriptions-billing-title">
            {{ trans('filament-subscriptions::messages.view.billing_management') }}
        </div>
        <div class="fi-subscriptions-billing-muted">
            {{ trans('filament-subscriptions::messages.view.signed_in_as') }} {{ $user->name }}.
            {{ trans('filament-subscriptions::messages.view.managing_billing_for') }} {{ $user->name }}.
        </div>
        <div class="fi-subscriptions-billing-muted">
            {{ trans('filament-subscriptions::messages.view.our_billing_management') }}
        </div>
        <div>
            <x-filament::link
                :href="filament()->getCurrentOrDefaultPanel()->getUrl()"
                icon="heroicon-m-arrow-left"
            >
                {{ trans('filament-subscriptions::messages.view.return_to') }}
            </x-filament::link>
        </div>
    </aside>

    <div class="fi-subscriptions-billing-main">
        <x-filament::section :heading="trans('filament-subscriptions::messages.view.subscribe')">
            @if (! $user->subscribedPlans()->first())
                <div class="fi-subscriptions-billing-notice">
                    {{ trans('filament-subscriptions::messages.view.it_looks_like_no_active_subscription') }}
                </div>
            @endif

            <div class="fi-subscriptions-billing-plans">
                @forelse ($plans as $plan)
                    <x-filament::section
                        :heading="$plan->name"
                        :description="$plan->description"
                    >
                        <div>
                            @if ($plan->isFree())
                                <span class="fi-subscriptions-billing-price">{{ trans('filament-subscriptions::messages.view.free') }}</span>
                            @else
                                <span class="fi-subscriptions-billing-price">{{ Number::currency($plan->price + $plan->signup_fee, in: $plan->currency) }}</span>
                                <span class="fi-subscriptions-billing-muted">/ {{ $plan->invoice_period > 1 ? $plan->invoice_period : '' }} {{ $plan->invoice_interval }}</span>
                                @if ($plan->hasTrial())
                                    <div class="fi-subscriptions-billing-muted">
                                        {{ $plan->trial_period }} {{ $plan->trial_interval }} {{ trans('filament-subscriptions::messages.view.trial') }}
                                    </div>
                                @endif
                            @endif
                        </div>

                        <div class="fi-subscriptions-billing-features">
                            @foreach ($plan->features as $feature)
                                @php
                                    $included = is_numeric($feature->value) || in_array($feature->value, ['true', 'unlimited'], true);
                                @endphp
                                <div class="fi-subscriptions-billing-feature">
                                    <x-filament::icon
                                        :icon="$included ? 'heroicon-s-check-circle' : 'heroicon-s-x-circle'"
                                        :style="$included ? 'color: var(--success-500)' : 'color: var(--gray-400)'"
                                    />
                                    <span>
                                        {{ $feature->name }}
                                        @if (is_numeric($feature->value) || $feature->value === 'unlimited')
                                            ({{ __(Str::title($feature->value)) }})
                                        @endif
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <div style="margin-top: 1.25rem">
                            {{ ($this->changePlanAction($plan))(['plan' => $plan]) }}
                        </div>
                    </x-filament::section>
                @empty
                    <div class="fi-subscriptions-billing-muted">
                        {{ trans('filament-subscriptions::messages.view.no_plans_available') }}
                    </div>
                @endforelse
            </div>
        </x-filament::section>

        @if ($currentSubscription && $currentSubscription->active())
            <x-filament::section :heading="trans('filament-subscriptions::messages.view.cancel_subscription')">
                <div class="fi-subscriptions-billing-muted">
                    {{ trans('filament-subscriptions::messages.view.cancel_subscription_info') }}
                </div>
                <div style="margin-top: .75rem">
                    {{ $this->cancelPlanAction }}
                </div>
            </x-filament::section>
        @endif
    </div>

    <x-filament-actions::modals />
</div>
