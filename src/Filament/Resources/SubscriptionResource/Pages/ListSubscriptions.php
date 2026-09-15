<?php

namespace TomatoPHP\FilamentSubscriptions\Filament\Resources\SubscriptionResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\SubscriptionResource;

class ListSubscriptions extends ManageRecords
{
    protected static string $resource = SubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
