<?php

namespace TomatoPHP\FilamentSubscriptions\Services;

use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use TomatoPHP\FilamentSubscriptions\Services\Contracts\Subscriber;
use Illuminate\Support\Str;
use TomatoPHP\FilamentSubscriptions\Models\Plan;
use TomatoPHP\FilamentSubscriptions\Models\Subscription;

class FilamentSubscriptionServices
{
    public static array $authorTypes = [];

    public \Closure $afterSubscription;
    public \Closure $afterRenew;
    public \Closure $afterCanceling;
    public \Closure $afterChange;

    private string $currentPanel;

    public function __construct()
    {
        $this->currentPanel = Filament::getCurrentPanel()->getId();
        $this->afterSubscription = function(array $data) {
            Notification::make()
                ->title(trans('filament-subscriptions::messages.notifications.subscription.title'))
                ->body(trans('filament-subscriptions::messages.notifications.subscription.message'))
                ->success()
                ->send();
            return redirect()->to($this->currentPanel);
        };
        $this->afterRenew = function(array $data) {
            Notification::make()
                ->title(trans('filament-subscriptions::messages.notifications.renew.title'))
                ->body(trans('filament-subscriptions::messages.notifications.renew.message'))
                ->success()
                ->send();

            return redirect()->to($this->currentPanel);
        };
        $this->afterCanceling = function(array $data) {
            Notification::make()
                ->title(trans('filament-subscriptions::messages.notifications.cancel.title'))
                ->body(trans('filament-subscriptions::messages.notifications.cancel.message'))
                ->success()
                ->send();
            return redirect()->to($this->currentPanel);
        };
        $this->afterChange = function(array $data) {
            Notification::make()
                ->title(trans('filament-subscriptions::messages.notifications.change.title'))
                ->body(trans('filament-subscriptions::messages.notifications.change.message'))
                ->success()
                ->send();
            return redirect()->to($this->currentPanel);
        };
    }

    public function getAfterRenew(): \Closure
    {
        return $this->afterRenew;
    }

    public function getAfterSubscription(): \Closure
    {
        return $this->afterSubscription;
    }

    public function getAfterCanceling(): \Closure
    {
        return $this->afterCanceling;
    }

    public function getAfterChange(): \Closure
    {
        return $this->afterChange;
    }

    public static function register(Subscriber|array $author)
    {
        if(is_array($author)) {
            foreach($author as $type) {
                self::register($type);
            }
            return;
        }
        self::$authorTypes[] = $author;
    }

    public function afterSubscription(\Closure $afterSubscription): void
    {
        $this->afterSubscription = $afterSubscription;
    }

    public function afterRenew(\Closure $afterRenew): void
    {
        $this->afterRenew = $afterRenew;
    }

    public function afterCanceling(\Closure $afterCanceling): void
    {
        $this->afterCanceling = $afterCanceling;
    }

    public function afterChange(\Closure $afterChange): void
    {
        $this->afterChange = $afterChange;
    }

    public static function getOptions(): Collection
    {
        return collect(self::$authorTypes);
    }
}
