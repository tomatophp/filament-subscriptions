<?php

namespace TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource;

class EditPlan extends EditRecord
{
    protected static string $resource = PlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    /**
     * Fill the translatable fields with every locale, not the current-locale string.
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        return PlanResource::fillTranslations($this->getRecord(), $data);
    }
}
