<?php

namespace TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource;

class ListPlans extends ListRecords
{
    protected static string $resource = PlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
