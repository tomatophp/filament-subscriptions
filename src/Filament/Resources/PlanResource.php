<?php

namespace TomatoPHP\FilamentSubscriptions\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Laravelcm\Subscriptions\Interval;
use TomatoPHP\FilamentLocations\Models\Currency;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource\Pages\CreatePlan;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource\Pages\EditPlan;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource\Pages\ListPlans;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource\RelationManagers\FeatureManager;
use TomatoPHP\FilamentSubscriptions\Models\Plan;
use TomatoPHP\FilamentTranslationComponent\Components\Translation;

class PlanResource extends Resource
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-bookmark';

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

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Translation::make('name')
                            ->columnSpanFull()
                            ->label(trans('filament-subscriptions::messages.plans.columns.name'))
                            ->required(),
                        Translation::make('description')
                            ->columnSpanFull()
                            ->label(trans('filament-subscriptions::messages.plans.columns.description')),
                        Select::make('currency')
                            ->columnSpanFull()
                            ->default('USD')
                            ->searchable()
                            ->label(trans('filament-subscriptions::messages.plans.columns.currency'))
                            ->options(Currency::query()->pluck('name', 'iso')->toArray())
                            ->required(),
                        TextInput::make('price')
                            ->default(0)
                            ->label(trans('filament-subscriptions::messages.plans.columns.price'))
                            ->required()
                            ->numeric()
                            ->prefix('$'),
                        TextInput::make('signup_fee')
                            ->label(trans('filament-subscriptions::messages.plans.columns.signup_fee'))
                            ->default(0)
                            ->numeric()
                            ->prefix('$'),
                        Select::make('invoice_interval')
                            ->default(Interval::MONTH->value)
                            ->label(trans('filament-subscriptions::messages.plans.columns.invoice_interval'))
                            ->options([
                                Interval::DAY->value => trans('filament-subscriptions::messages.plans.columns.day'),
                                Interval::MONTH->value => trans('filament-subscriptions::messages.plans.columns.month'),
                                Interval::YEAR->value => trans('filament-subscriptions::messages.plans.columns.year'),
                            ])->required(),
                        TextInput::make('invoice_period')
                            ->label(trans('filament-subscriptions::messages.plans.columns.invoice_period'))
                            ->default(0)
                            ->numeric()
                            ->required(),
                        Select::make('trial_interval')
                            ->default(Interval::MONTH->value)
                            ->label(trans('filament-subscriptions::messages.plans.columns.trial_interval'))
                            ->default(0)
                            ->options([
                                Interval::DAY->value => trans('filament-subscriptions::messages.plans.columns.day'),
                                Interval::MONTH->value => trans('filament-subscriptions::messages.plans.columns.month'),
                                Interval::YEAR->value => trans('filament-subscriptions::messages.plans.columns.year'),
                            ]),
                        TextInput::make('trial_period')
                            ->label(trans('filament-subscriptions::messages.plans.columns.trial_period'))
                            ->default(0)
                            ->numeric(),
                        Toggle::make('is_active')
                            ->label(trans('filament-subscriptions::messages.plans.columns.is_active')),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('name')
                    ->label(trans('filament-subscriptions::messages.plans.columns.name'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('price')
                    ->label(trans('filament-subscriptions::messages.plans.columns.price'))
                    ->sortable()
                    ->searchable()
                    ->money(locale: 'en', currency: function ($record) {
                        return $record->currency;
                    })
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label(trans('filament-subscriptions::messages.plans.columns.is_active')),
            ])
            ->defaultSort('sort_order', 'aces')
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Translatable attributes (name, description) as locale => value arrays for the Translation field,
     * instead of the current-locale string that attributesToArray() returns.
     */
    public static function fillTranslations(Model $record, array $data): array
    {
        if (! method_exists($record, 'getTranslations')) {
            return $data;
        }

        foreach (['name', 'description'] as $attribute) {
            $data[$attribute] = $record->getTranslations($attribute);
        }

        return $data;
    }

    public static function getRelations(): array
    {
        return [
            FeatureManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPlans::route('/'),
            'create' => CreatePlan::route('/create'),
            'edit' => EditPlan::route('/{record}/edit'),
        ];
    }
}
