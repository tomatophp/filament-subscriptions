<?php

namespace TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Laravelcm\Subscriptions\Interval;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource;
use TomatoPHP\FilamentTranslationComponent\Components\Translation;

class FeatureManager extends RelationManager
{
    protected static string $relationship = 'features';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return trans('filament-subscriptions::messages.features.title');
    }

    public static function getLabel(): ?string
    {
        return trans('filament-subscriptions::messages.features.title');
    }

    public static function getModelLabel(): ?string
    {
        return trans('filament-subscriptions::messages.features.single');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('filament-subscriptions::messages.features.title');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Translation::make('name')
                    ->label(trans('filament-subscriptions::messages.features.columns.name'))
                    ->columnSpanFull()
                    ->required(),
                Translation::make('description')
                    ->columnSpanFull()
                    ->label(trans('filament-subscriptions::messages.features.columns.description')),
                TextInput::make('value')
                    ->columnSpanFull()
                    ->default(0)
                    ->label(trans('filament-subscriptions::messages.features.columns.value'))
                    ->required(),
                Select::make('resettable_interval')
                    ->default(Interval::DAY->value)
                    ->label(trans('filament-subscriptions::messages.features.columns.resettable_interval'))
                    ->options([
                        Interval::DAY->value => trans('filament-subscriptions::messages.features.columns.day'),
                        Interval::MONTH->value => trans('filament-subscriptions::messages.features.columns.month'),
                        Interval::YEAR->value => trans('filament-subscriptions::messages.features.columns.year'),
                    ])->required(),
                TextInput::make('resettable_period')
                    ->label(trans('filament-subscriptions::messages.features.columns.resettable_period'))
                    ->required()
                    ->default(0)
                    ->numeric(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->recordTitleAttribute('feature')
            ->columns([
                TextColumn::make('name')
                    ->label(trans('filament-subscriptions::messages.features.columns.name'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('value')
                    ->label(trans('filament-subscriptions::messages.features.columns.value'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('resettable_interval')
                    ->label(trans('filament-subscriptions::messages.features.columns.resettable_interval'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('resettable_period')
                    ->label(trans('filament-subscriptions::messages.features.columns.resettable_period'))
                    ->sortable()
                    ->searchable(),
            ])
            ->defaultSort('sort_order', 'aces')
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make()
                    ->mutateRecordDataUsing(fn (array $data, Model $record): array => PlanResource::fillTranslations($record, $data)),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
