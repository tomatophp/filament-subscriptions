<?php

namespace TomatoPHP\FilamentSubscriptions\Filament\Resources\SubscriptionResource\Pages;

use TomatoPHP\FilamentSubscriptions\Filament\Resources\SubscriptionResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Laravelcm\Subscriptions\Models\Plan;

class EditSubscription extends EditRecord
{
    protected static string $resource = SubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordCreation(array $data): Model
    {
        $useCustomDates = isset($data['use_custom_dates']) ? (bool) $data['use_custom_dates'] : false;

        $subscriberType = $data['subscriber_type'];
        $subscriberModel = $subscriberType::find($data['subscriber_id']);

        if (!$subscriberModel) {
            return Notification::make()
                ->warning()
                ->title('Subscriber not found.');
        }

        $plan = Plan::find($data['plan_id']);

        if ($useCustomDates) {
            $subscription = $this->getModel()::create([
                'subscriber_type' => $data['subscriber_type'],
                'subscriber_id' => $data['subscriber_id'],
                'name' => 'main',
                'plan_id' => $data['plan_id'],
                'trial_ends_at' => $data['trial_ends_at'] ?? null,
                'starts_at' => $data['starts_at'] ?? null,
                'ends_at' => $data['ends_at'] ?? null,
                'canceled_at' => $data['canceled_at'] ?? null,
            ]);
        } else {
            // Change subscription plan
            $subscriberModel->changePlan($plan);

            $subscription = $this->getModel()::where('subscriber_type', $data['subscriber_type'])
                ->where('subscriber_id', $data['subscriber_id'])
                ->where('plan_id', $data['plan_id'])
                ->first();
        }

        return $subscription;
    }
}
