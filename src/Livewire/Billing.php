<?php

namespace TomatoPHP\FilamentSubscriptions\Livewire;

use Filament\Notifications\Notification;
use Laravelcm\Subscriptions\Models\Plan;
use Livewire\Component;

class Billing extends Component
{
    public $user;
    public $plans;
    public $currentSubscription;

    public function mount()
    {
        $this->user = auth()->user();
        $this->plans = Plan::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        $this->currentSubscription = $this->user->planSubscriptions()->first();
    }

    public function subscribe(Plan $plan)
    {
        if (!$plan) {
            Notification::make()
                ->title(trans('filament-subscriptions::messages.notifications.invalid.title'))
                ->body(trans('filament-subscriptions::messages.notifications.invalid.message'))
                ->danger()
                ->send();
            return redirect()->back();
        }

        if ($this->currentSubscription) {
            if ($this->currentSubscription->plan_id === $plan->id) {
                if ($this->currentSubscription->active()) {
                    Notification::make()
                        ->title(trans('filament-subscriptions::messages.notifications.info.title'))
                        ->body(trans('filament-subscriptions::messages.notifications.info.message'))
                        ->info()
                        ->send();
                    return redirect()->back();
                }

                $this->currentSubscription->renew();
                Notification::make()
                    ->title(trans('filament-subscriptions::messages.notifications.renew.title'))
                    ->body(trans('filament-subscriptions::messages.notifications.renew.message'))
                    ->success()
                    ->send();
                return redirect()->back();
            }

            $this->currentSubscription->changePlan($plan);
            Notification::make()
                ->title(trans('filament-subscriptions::messages.notifications.change.title'))
                ->body(trans('filament-subscriptions::messages.notifications.change.message'))
                ->success()
                ->send();
            return redirect()->back();
        }

        // No current subscription
        $this->user->newPlanSubscription('main', $plan);
        Notification::make()
            ->title(trans('filament-subscriptions::messages.notifications.subscription.title'))
            ->body(trans('filament-subscriptions::messages.notifications.subscription.message'))
            ->success()
            ->send();
        return redirect()->back();
    }

    public function cancel()
    {
        $activeSubscriptions = $this->user->activePlanSubscriptions();

        if ($activeSubscriptions->isEmpty()) {
            Notification::make()
                ->title(trans('filament-subscriptions::messages.notifications.no_active.title'))
                ->body(trans('filament-subscriptions::messages.notifications.no_active.message'))
                ->danger()
                ->send();
            return redirect()->back();
        }

        try {
            foreach ($activeSubscriptions as $subscription) {
                $subscription->cancel();
            }
            Notification::make()
                ->title(trans('filament-subscriptions::messages.notifications.cancel.title'))
                ->body(trans('filament-subscriptions::messages.notifications.cancel.message'))
                ->success()
                ->send();
            return redirect()->back();
        } catch (\Exception $e) {
            Notification::make()
                ->title(trans('filament-subscriptions::messages.notifications.cancel_invalid.title'))
                ->body(trans('filament-subscriptions::messages.notifications.cancel_invalid.message'))
                ->danger()
                ->send();
            return redirect()->back();
        }
    }

    public function render()
    {
        return view('filament-subscriptions::livewire.billing');
    }
}