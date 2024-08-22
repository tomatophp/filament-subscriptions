<?php

namespace TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use TomatoPHP\FilamentTranslationComponent\Components\Translation;

class FeatureManager extends RelationManager
{
    protected static string $relationship = 'features';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return trans('filament-subscriptions::messages.features.title');
    }

    /**
     * @return string|null
     */
    public static function getLabel(): ?string
    {
        return trans('filament-subscriptions::messages.features.title');
    }

    /**
     * @return string|null
     */
    public static function getModelLabel(): ?string
    {
        return trans('filament-subscriptions::messages.features.single');
    }

    /**
     * @return string|null
     */
    public static function getPluralLabel(): ?string
    {
        return trans('filament-subscriptions::messages.features.title');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Translation::make('name')
                    ->label(trans('filament-subscriptions::messages.features.columns.name'))
                    ->required(),
                Translation::make('description')
                    ->label(trans('filament-subscriptions::messages.features.columns.description')),
                Forms\Components\TextInput::make('value')
                    ->label(trans('filament-subscriptions::messages.features.columns.value'))
                    ->required(),
                Forms\Components\Select::make('resettable_interval')
                    ->label(trans('filament-subscriptions::messages.features.columns.resettable_interval'))
                    ->options([
                        'day' => trans('filament-subscriptions::messages.features.columns.day'),
                        'month' => trans('filament-subscriptions::messages.features.columns.month'),
                        'year' => trans('filament-subscriptions::messages.features.columns.year'),
                    ])->required(),
                Forms\Components\TextInput::make('resettable_period')
                    ->label(trans('filament-subscriptions::messages.features.columns.resettable_period'))
                    ->required()
                    ->numeric(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->recordTitleAttribute('feature')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('filament-subscriptions::messages.features.columns.name'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->label(trans('filament-subscriptions::messages.features.columns.value'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('resettable_interval')
                    ->label(trans('filament-subscriptions::messages.features.columns.resettable_interval'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('resettable_period')
                    ->label(trans('filament-subscriptions::messages.features.columns.resettable_period'))
                    ->sortable()
                    ->searchable(),
            ])
            ->defaultSort('sort_order', 'aces')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
