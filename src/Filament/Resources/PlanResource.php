<?php

namespace TomatoPHP\FilamentSubscriptions\Filament\Resources;

use TomatoPHP\FilamentLocations\Models\Currency;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource\Pages;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Laravelcm\Subscriptions\Interval;
use TomatoPHP\FilamentSubscriptions\Models\Plan;
use TomatoPHP\FilamentTranslationComponent\Components\Translation;

class PlanResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    protected static ?int $navigationSort = 1;

    public static function getModel(): string
    {
        return config('laravel-subscriptions.models.plan', Plan::class);
    }

    public static function getNavigationGroup(): ?string
    {
        return config('laravel-subscriptions.navigation.group', trans('filament-subscriptions::messages.group'));
    }

    public static function getNavigationLabel(): string
    {
        return trans('filament-subscriptions::messages.plans.title');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('filament-subscriptions::messages.plans.title');
    }

    public static function getLabel(): ?string
    {
        return trans('filament-subscriptions::messages.plans.title');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Translation::make('name')
                            ->columnSpanFull()
                            ->label(trans('filament-subscriptions::messages.plans.columns.name'))
                            ->required(),
                        Translation::make('description')
                            ->columnSpanFull()
                            ->label(trans('filament-subscriptions::messages.plans.columns.description')),
                        Forms\Components\Select::make('currency')
                            ->columnSpanFull()
                            ->default('USD')
                            ->searchable()
                            ->label(trans('filament-subscriptions::messages.plans.columns.currency'))
                            ->options(Currency::query()->pluck('name', 'iso')->toArray())
                            ->required(),
                        Forms\Components\TextInput::make('price')
                            ->default(0)
                            ->label(trans('filament-subscriptions::messages.plans.columns.price'))
                            ->required()
                            ->numeric()
                            ->prefix('$'),
                        Forms\Components\TextInput::make('signup_fee')
                            ->label(trans('filament-subscriptions::messages.plans.columns.signup_fee'))
                            ->default(0)
                            ->numeric()
                            ->prefix('$'),
                        Forms\Components\Select::make('invoice_interval')
                            ->default(Interval::MONTH->value)
                            ->label(trans('filament-subscriptions::messages.plans.columns.invoice_interval'))
                            ->options([
                                Interval::DAY->value => trans('filament-subscriptions::messages.plans.columns.day'),
                                Interval::MONTH->value => trans('filament-subscriptions::messages.plans.columns.month'),
                                Interval::YEAR->value => trans('filament-subscriptions::messages.plans.columns.year'),
                            ])->required(),
                        Forms\Components\TextInput::make('invoice_period')
                            ->label(trans('filament-subscriptions::messages.plans.columns.invoice_period'))
                            ->default(0)
                            ->numeric()
                            ->required(),
                        Forms\Components\Select::make('trial_interval')
                            ->default(Interval::MONTH->value)
                            ->label(trans('filament-subscriptions::messages.plans.columns.trial_interval'))
                            ->default(0)
                            ->options([
                                Interval::DAY->value => trans('filament-subscriptions::messages.plans.columns.day'),
                                Interval::MONTH->value => trans('filament-subscriptions::messages.plans.columns.month'),
                                Interval::YEAR->value => trans('filament-subscriptions::messages.plans.columns.year'),
                            ]),
                        Forms\Components\TextInput::make('trial_period')
                            ->label(trans('filament-subscriptions::messages.plans.columns.trial_period'))
                            ->default(0)
                            ->numeric(),
                        Forms\Components\Toggle::make('is_active')
                            ->label(trans('filament-subscriptions::messages.plans.columns.is_active')),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('filament-subscriptions::messages.plans.columns.name'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label(trans('filament-subscriptions::messages.plans.columns.price'))
                    ->sortable()
                    ->searchable()
                    ->money(locale: 'en', currency: function ($record){
                        return $record->currency;
                    })
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label(trans('filament-subscriptions::messages.plans.columns.is_active')),
            ])
            ->defaultSort('sort_order', 'aces')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\FeatureManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
