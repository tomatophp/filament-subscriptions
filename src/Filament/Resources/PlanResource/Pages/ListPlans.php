<?php

namespace TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource\Pages;

use TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlans extends ListRecords
{
    protected static string $resource = PlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
