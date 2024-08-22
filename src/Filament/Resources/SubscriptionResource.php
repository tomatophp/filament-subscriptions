<?php

namespace TomatoPHP\FilamentSubscriptions\Filament\Resources;

use TomatoPHP\FilamentSubscriptions\Filament\Resources\SubscriptionResource\Pages;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\SubscriptionResource\RelationManagers;
use App\Models\User;
use TomatoPHP\FilamentSubscriptions\Services\FilamentSubscriptionSubscribers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use TomatoPHP\FilamentSubscriptions\Models\Subscription;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return trans('filament-subscriptions::messages.group');
    }

    public static function getNavigationLabel(): string
    {
        return trans('filament-subscriptions::messages.subscriptions.title');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('filament-subscriptions::messages.subscriptions.title');
    }

    public static function getLabel(): ?string
    {
        return trans('filament-subscriptions::messages.subscriptions.title');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make([
                    'sm' => 1,
                    'lg' => 12,
                ])->schema([
                    Forms\Components\Section::make(trans('filament-subscriptions::messages.subscriptions.sections.subscriber.title'))
                        ->description(trans('filament-subscriptions::messages.subscriptions.sections.subscriber.description'))
                        ->schema([
                            Forms\Components\Select::make('subscriber_type')
                                ->label(trans('filament-subscriptions::messages.subscriptions.sections.subscriber.columns.subscriber_type'))
                                ->options(count(FilamentSubscriptionSubscribers::getOptions()) ? FilamentSubscriptionSubscribers::getOptions()->pluck('name', 'model')->toArray() : [User::class => 'Users'])
                                ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => $set('subscriber_id', null))
                                ->preload()
                                ->live()
                                ->searchable(),
                            Forms\Components\Select::make('subscriber_id')
                                ->label(trans('filament-subscriptions::messages.subscriptions.sections.subscriber.columns.subscriber'))
                                ->options(fn(Forms\Get $get) => $get('subscriber_type') ? $get('subscriber_type')::pluck('name', 'id')->toArray() : [])
                                ->searchable(),
                        ])->columnSpan(6),

                    Forms\Components\Section::make(trans('filament-subscriptions::messages.subscriptions.sections.plan.title'))
                        ->description(trans('filament-subscriptions::messages.subscriptions.sections.plan.description'))
                        ->schema([
                            Forms\Components\Select::make('plan_id')
                                ->label(trans('filament-subscriptions::messages.subscriptions.sections.plan.columns.plan'))
                                ->relationship('plan', 'name')
                                ->required(),
                            Forms\Components\Toggle::make('use_custom_dates')
                                ->label(trans('filament-subscriptions::messages.subscriptions.sections.plan.columns.use_custom_dates'))
                                ->live()
                                ->required(),
                        ])->columnSpan(6),
                ]),

                Forms\Components\Section::make(trans('filament-subscriptions::messages.subscriptions.sections.custom_dates.title'))
                    ->description(trans('filament-subscriptions::messages.subscriptions.sections.custom_dates.description'))
                    ->schema([
                        Forms\Components\DatePicker::make('trial_ends_at')
                            ->label(trans('filament-subscriptions::messages.subscriptions.sections.custom_dates.columns.trial_ends_at'))
                            ->required(fn(Forms\Get $get) => $get('use_custom_dates')),
                        Forms\Components\DatePicker::make('starts_at')
                            ->label(trans('filament-subscriptions::messages.subscriptions.sections.custom_dates.columns.starts_at'))
                            ->required(fn(Forms\Get $get) => $get('use_custom_dates')),
                        Forms\Components\DatePicker::make('ends_at')
                            ->label(trans('filament-subscriptions::messages.subscriptions.sections.custom_dates.columns.ends_at'))
                            ->required(fn(Forms\Get $get) => $get('use_custom_dates')),
                        Forms\Components\DatePicker::make('canceled_at')
                            ->label(trans('filament-subscriptions::messages.subscriptions.sections.custom_dates.columns.canceled_at'))
                            ->required(fn(Forms\Get $get) => $get('use_custom_dates')),
                    ])
                    ->visible(fn(Forms\Get $get) => $get('use_custom_dates')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subscriber.name')
                    ->label(trans('filament-subscriptions::messages.subscriptions.columns.subscriber'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('plan.name')
                    ->label(trans('filament-subscriptions::messages.subscriptions.columns.plan'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('trial_ends_at')->dateTime()
                    ->label(trans('filament-subscriptions::messages.subscriptions.columns.trial_ends_at'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('starts_at')->dateTime()
                    ->label(trans('filament-subscriptions::messages.subscriptions.columns.starts_at'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('ends_at')->dateTime()
                    ->label(trans('filament-subscriptions::messages.subscriptions.columns.ends_at'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('canceled_at')->dateTime()
                    ->label(trans('filament-subscriptions::messages.subscriptions.columns.canceled_at'))
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\Filter::make(trans('filament-subscriptions::messages.subscriptions.filters.date_range'))
                    ->form([
                        Forms\Components\DatePicker::make('start_date')
                            ->label(trans('filament-subscriptions::messages.subscriptions.filters.start_date'))
                            ->required(),
                        Forms\Components\DatePicker::make('end_date')
                            ->label(trans('filament-subscriptions::messages.subscriptions.filters.end_date'))
                            ->required(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!isset($data['start_date']) || !isset($data['end_date'])) {
                            return $query;
                        }
                        return $query->whereBetween('starts_at', [$data['start_date'], $data['end_date']]);
                    }),
                Tables\Filters\Filter::make(trans('filament-subscriptions::messages.subscriptions.filters.canceled'))
                    ->form([
                        Forms\Components\Select::make('canceled')
                            ->options([
                                '' => trans('filament-subscriptions::messages.subscriptions.filters.all'),
                                '1' => trans('filament-subscriptions::messages.subscriptions.filters.yes'),
                                '0' => trans('filament-subscriptions::messages.subscriptions.filters.no'),
                            ])
                            ->label(trans('filament-subscriptions::messages.subscriptions.filters.canceled'))
                            ->required(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!isset($data['canceled'])) {
                            return $query;
                        }
                        if ($data['canceled'] === '1') {
                            return $query->whereNotNull('canceled_at');
                        }
                        if ($data['canceled'] === '0') {
                            return $query->whereNull('canceled_at');
                        }
                        return $query;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('cancel')
                    ->label(trans('filament-subscriptions::messages.subscriptions.actions.cancel'))
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->action(fn(Subscription $record) => $record->cancel())
                    ->requiresConfirmation(),
                Tables\Actions\Action::make('renew')
                    ->label(trans('filament-subscriptions::messages.subscriptions.actions.renew'))
                    ->icon('heroicon-o-arrow-path-rounded-square')
                    ->color('info')
                    ->action(fn(Subscription $record) => $record->renew())
                    ->requiresConfirmation(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
