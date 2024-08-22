<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME', 'Laravel') }}</title>

    @filamentStyles

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="lg:min-h-screen bg flex flex-wrap lg:flex-nowrap">
        <div id="sideBar" class="order-last lg:order-first lg:w-92 py-10 lg:pt-24 px-6 bg-white lg:shadow-lg">
            <h1 class="text-3xl font-bold text-gray-900">
                {{ env('APP_NAME', 'Laravel') }}
            </h1>
            <h2 class="mt-1 text-lg font-semibold text-gray-700">
                {{ trans('filament-subscriptions::messages.view.billing_management') }}
            </h2>
            <div class="flex items-center mt-12 text-gray-600">
                <div>
                    {{ trans('filament-subscriptions::messages.view.signed_in_as') }}
                </div>
                <div class="ml-1">
                    {{ $user->name }}.
                </div>
            </div>
            <div class="mt-3 text-sm text-gray-600">
                {{ trans('filament-subscriptions::messages.view.managing_billing_for') }} {{ $user->name }}.
            </div>
            <div class="mt-12 text-gray-600">
                {{ trans('filament-subscriptions::messages.view.our_billing_management') }}
            </div>
            <div id="sideBarReturnLink" class="mt-12">
                <a href="/app" class="flex items-center">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="arrow-left w-5 h-5 text-gray-400">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-2 text-gray-600 underline">
                        {{ trans('filament-subscriptions::messages.view.return_to') }} {{ env('APP_NAME', 'Laravel') }}
                    </div>
                </a>
            </div>
        </div>
        <div class="w-full lg:flex-1 bg-gray-100">
            <a href="/app" id="topNavReturnLink" class="lg:hidden flex items-center w-full px-4 py-4 bg-white shadow-lg">
                <svg viewBox="0 0 20 20" fill="currentColor" class="arrow-left w-4 h-4 text-gray-400">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                </svg>
                <div class="ml-2 text-gray-600 underline">
                    {{ trans('filament-subscriptions::messages.view.return_to') }} {{ env('APP_NAME', 'Laravel') }}
                </div>
            </a>
            <div class="sm:px-8 pb-10 pt-6 lg:pt-24 lg:pb-24 lg:max-w-4xl lg:mx-auto flex flex-col space-y-10">
                <h1 class="px-6 sm:px-0 text-2xl font-semibold text-gray-700">
                    {{ trans('filament-subscriptions::messages.view.subscribe') }}
                </h1>

                @if (!$user->subscribedPlans()->first())
                    <div class="mt-6">
                        <div>
                            <div class="px-6 py-4 bg-gray-200 border border-gray-300 sm:rounded-lg shadow-sm mb-6">
                                <div class="max-w-2xl text-sm text-gray-600">
                                    {{ trans('filament-subscriptions::messages.view.it_looks_like_no_active_subscription') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Plans --}}
                <div class="space-y-6 mt-6">
                    @csrf
                    @forelse ($plans as $plan)
                        <div class="bg-white sm:rounded-lg shadow-sm overflow-hidden">
                            <div>
                                <div class="flex justify-between">
                                    <h2 class="pl-6 pt-6 text-xl font-semibold text-gray-700">
                                        {{ $plan->name }}
                                    </h2>
                                </div>
                                <div class="px-6 pb-6">
                                    <div class="mt-2 text-md font-semibold text-gray-700">
                                        @if ($plan->isFree())
                                            <span>{{ trans('filament-subscriptions::messages.view.free') }}</span>
                                        @else
                                            <span>{{ Number::currency($plan->price + $plan->signup_fee, in: $plan->currency) }}</span>
                                            <span>/ {{ $plan->invoice_period > 1 ? $plan->invoice_period : '' }} {{ $plan->invoice_interval }}</span>
                                            @if ($plan->hasTrial())
                                                <br>
                                                <span>{{ $plan->trial_period }} {{ $plan->trial_interval }} {{ trans('filament-subscriptions::messages.view.trial') }}</span>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="mt-3 max-w-xl text-sm text-gray-600">
                                        {{ $plan->description }}
                                    </div>
                                    <div class="mt-3 space-y-2">
                                        @foreach ($plan->features as $feature)
                                            <div class="flex items-center">
                                                @if (is_numeric($feature->value) || $feature->value == 'true' || $feature->value == 'unlimited')
                                                    <svg viewBox="0 0 20 20" fill="currentColor" class="flex-shrink-0 w-5 h-5 text-green-400">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @else
                                                    <svg viewBox="0 0 20 20" fill="currentColor" class="flex-shrink-0 w-5 h-5 text-gray-400">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                                <div class="ml-2 text-sm text-gray-600">
                                                    {{ $feature->name }}
                                                    @if (is_numeric($feature->value) || $feature->value == 'unlimited')
                                                        ({{ __(Str::title($feature->value)) }})
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-4 bg-gray-100 bg-opacity-50 border-t border-gray-100 text-right">
                                <form action="{{ route('subscription.subscribe', $plan->id) }}" method="POST">
                                    @csrf
                                    @php
                                        $hasSubscription = $user->planSubscriptions()->first();
                                    @endphp
                                    @if ($hasSubscription)
                                        @if ($hasSubscription->plan_id === $plan->id)
                                            @if ($hasSubscription->active())
                                                <button disabled class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                                    {{ trans('filament-subscriptions::messages.view.current_subscription') }}
                                                </button>
                                            @else
                                                <button class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                                    {{ trans('filament-subscriptions::messages.view.renew_subscription') }}
                                                </button>
                                            @endif
                                        @else
                                            <button class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                                {{ trans('filament-subscriptions::messages.view.change_subscription') }}
                                            </button>
                                        @endif
                                    @else
                                        <button class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                            {{ trans('filament-subscriptions::messages.view.subscribe') }}
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    @empty
                        <div>
                            {{ trans('filament-subscriptions::messages.view.no_plans_available') }}
                        </div>
                    @endforelse
                </div>

                {{-- Cancel Subscription --}}
                @if (!$user->activePlanSubscriptions()->isEmpty())
                    <div class="space-y-6 mt-6">
                        <h2 class="px-6 sm:px-0 text-2xl font-semibold text-gray-700">
                            {{ trans('filament-subscriptions::messages.view.cancel_subscription') }}
                        </h2>
                        <div class="bg-white sm:rounded-lg shadow-sm overflow-hidden">
                            <div class="px-6 pb-6">
                                <div class="mt-3 max-w-xl text-sm text-gray-600">
                                    {{ trans('filament-subscriptions::messages.view.cancel_subscription_info') }}
                                </div>
                            </div>
                            <div class="px-6 py-4 bg-gray-100 bg-opacity-50 border-t border-gray-100 text-right">
                                <form action="{{ route('subscription.cancel') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                                        {{ trans('filament-subscriptions::messages.view.cancel_subscription') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    @filamentScripts
</body>
</html>