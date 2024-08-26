<?php

namespace TomatoPHP\FilamentSubscriptions\Filament\Pages;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Pages\SimplePage;
use Filament\Pages\Concerns;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Carbon;
use Laravelcm\Subscriptions\Models\Plan;
use TomatoPHP\FilamentSubscriptions\Http\Middleware\VerifyBillableIsSubscribed;

class Billing extends Page implements HasActions
{
    use Concerns\HasMaxWidth;
    use Concerns\HasTopbar;
    use InteractsWithActions;

    protected static string $layout = 'filament-subscriptions::layouts.billing';

    protected static string | array $withoutRouteMiddleware = VerifyBillableIsSubscribed::class;

    protected function getLayoutData(): array
    {
        return [
            'hasTopbar' => $this->hasTopbar(),
            'maxWidth' => $this->getMaxWidth(),
        ];
    }

    public function hasLogo(): bool
    {
        return true;
    }

    public function getMaxWidth(): MaxWidth | string | null
    {
        return MaxWidth::FiveExtraLarge;
    }

    protected static ?string $title = 'Billing';

    protected static string $view = 'filament-subscriptions::pages.billing';


    public $user;
    public $plans;
    public $currentSubscription;

    public function mount()
    {
        $this->user = auth()->user();
        $this->plans = Plan::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        $this->currentSubscription = $this->user->planSubscriptions()->first();

        if(!$this->currentSubscription){
            $this->user->newPlanSubscription('main', $this->plans->first());
            Notification::make()
                ->title(trans('filament-subscriptions::messages.notifications.subscription.title'))
                ->body(trans('filament-subscriptions::messages.notifications.subscription.message'))
                ->success()
                ->send();
            return redirect()->back();
        }
    }

    public function changePlanAction(?Plan $plan=null): Action
    {
        return Action::make('changePlanAction')
            ->requiresConfirmation()
            ->label(function() use ($plan){
                if($plan){
                    $hasSubscription = $this->user->planSubscriptions()->first();
                    if($hasSubscription){
                        if($hasSubscription->plan_id === $plan->id){
                            if($hasSubscription->active()){
                                return trans('filament-subscriptions::messages.view.current_subscription');
                            }
                            elseif($hasSubscription->canceled()){
                                return trans('filament-subscriptions::messages.view.resubscribe');
                            }
                            elseif($hasSubscription->ended()){
                                return trans('filament-subscriptions::messages.view.renew_subscription');
                            }
                        }
                        else {
                            return trans('filament-subscriptions::messages.view.change_subscription');
                        }
                    }
                    else {
                        return trans('filament-subscriptions::messages.view.subscribe');
                    }
                }
            })
            ->modalHeading(function(array $arguments){
                $plan = Plan::find($arguments['plan']['id']);
                if($plan){
                    $hasSubscription = $this->user->planSubscriptions()->first();
                    if($hasSubscription){
                        if($hasSubscription->plan_id === $plan->id){
                            if($hasSubscription->active()){
                                return trans('filament-subscriptions::messages.view.current_subscription');
                            }
                            elseif($hasSubscription->canceled()){
                                return trans('filament-subscriptions::messages.view.resubscribe');
                            }
                            elseif($hasSubscription->ended()){
                                return trans('filament-subscriptions::messages.view.renew_subscription');
                            }
                        }
                        else {
                            return trans('filament-subscriptions::messages.view.change_subscription');
                        }
                    }
                    else {
                        return trans('filament-subscriptions::messages.view.subscribe');
                    }
                }
            })
            ->disabled(function() use ($plan){
                if($plan){
                    $hasSubscription = $this->user->planSubscriptions()->first();
                    if($hasSubscription){
                        if($hasSubscription->plan_id === $plan->id){
                            if($hasSubscription->active()){
                                return true;
                            }
                        }
                    }
                }

                return false;
            })
            ->color(function() use ($plan){
                if($plan){
                    $hasSubscription = $this->user->planSubscriptions()->first();
                    if($hasSubscription){
                        if($hasSubscription->plan_id === $plan->id){
                            if($hasSubscription->active()){
                                return 'success';
                            }
                            else {
                                return 'warning';
                            }
                        }
                    }
                }

                return 'primary';
            })
            ->icon(function() use ($plan){
                if($plan){
                    $hasSubscription = $this->user->planSubscriptions()->first();
                    if($hasSubscription){
                        if($hasSubscription->plan_id === $plan->id){
                            if($hasSubscription->active()){
                                return 'heroicon-s-check-circle';
                            }
                            elseif($hasSubscription->canceled()){
                                return 'heroicon-s-arrow-path-rounded-square';
                            }
                            elseif($hasSubscription->ended()){
                                return 'heroicon-s-arrow-path-rounded-square';
                            }
                        }
                    }
                }

                return 'heroicon-s-arrows-right-left';
            })
            ->action(function(array $arguments){
                $this->subscribe($arguments['plan']['id']);
            });
    }

    public function cancelPlanAction()
    {
        return Action::make('cancelPlanAction')
            ->requiresConfirmation()
            ->label(trans('filament-subscriptions::messages.view.cancel_subscription'))
            ->action(function(){
                $this->cancel();
            });
    }

    public function subscribe(int $plan)
    {
        if (!$plan) {
            Notification::make()
                ->title(trans('filament-subscriptions::messages.notifications.invalid.title'))
                ->body(trans('filament-subscriptions::messages.notifications.invalid.message'))
                ->danger()
                ->send();
            return redirect()->back();
        }

        $plan = Plan::find($plan);

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

                $this->currentSubscription->canceled_at =  Carbon::parse($this->currentSubscription->cancels_at)->addDays(1);
                $this->currentSubscription->cancels_at = Carbon::parse($this->currentSubscription->cancels_at)->addDays(1);
                $this->currentSubscription->ends_at =  Carbon::parse($this->currentSubscription->cancels_at)->addDays(1);
                $this->currentSubscription->save();
                $this->currentSubscription->renew($plan);
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
                $subscription->cancel(true);
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
}
