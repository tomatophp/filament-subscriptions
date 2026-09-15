<?php

namespace TomatoPHP\FilamentSubscriptions\Filament\Resources;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use TomatoPHP\FilamentSubscriptions\Facades\FilamentSubscriptions;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\SubscriptionResource\Pages\ListSubscriptions;
use TomatoPHP\FilamentSubscriptions\Models\Plan;
use TomatoPHP\FilamentSubscriptions\Models\Subscription;

class SubscriptionResource extends Resource
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';

    protected static ?int $navigationSort = 2;

    public static function getModel(): string
    {
        return config('laravel-subscriptions.models.subscription', Subscription::class);
    }

    public static function getNavigationGroup(): ?string
    {
        return config('laravel-subscriptions.navigation.group', trans('filament-subscriptions::messages.group'));
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

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('name'),
                Select::make('subscriber_type')
                    ->label(trans('filament-subscriptions::messages.subscriptions.sections.subscriber.columns.subscriber_type'))
                    ->options(fn (): array => count(FilamentSubscriptions::getOptions()) ? FilamentSubscriptions::getOptions()->pluck('name', 'model')->toArray() : [config('auth.providers.users.model') => 'Users'])
                    ->afterStateUpdated(fn (Get $get, Set $set) => $set('subscriber_id', null))
                    ->preload()
                    ->live()
                    ->searchable(),
                Select::make('subscriber_id')
                    ->label(trans('filament-subscriptions::messages.subscriptions.sections.subscriber.columns.subscriber'))
                    ->options(fn (Get $get) => $get('subscriber_type') ? $get('subscriber_type')::pluck('name', 'id')->toArray() : [])
                    ->searchable(),
                Select::make('plan_id')
                    ->columnSpanFull()
                    ->searchable()
                    ->label(trans('filament-subscriptions::messages.subscriptions.sections.plan.columns.plan'))
                    ->options(Plan::query()->where('is_active', 1)->pluck('name', 'id')->toArray())
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $set('name', $get('plan_id') ? Plan::find($get('plan_id'))->name : null);
                    })
                    ->required(),
                Toggle::make('use_custom_dates')
                    ->columnSpanFull()
                    ->label(trans('filament-subscriptions::messages.subscriptions.sections.plan.columns.use_custom_dates'))
                    ->live()
                    ->required(),
                DatePicker::make('trial_ends_at')
                    ->visible(fn (Get $get) => $get('use_custom_dates'))
                    ->label(trans('filament-subscriptions::messages.subscriptions.sections.custom_dates.columns.trial_ends_at'))
                    ->required(fn (Get $get) => $get('use_custom_dates')),
                DatePicker::make('starts_at')
                    ->visible(fn (Get $get) => $get('use_custom_dates'))
                    ->label(trans('filament-subscriptions::messages.subscriptions.sections.custom_dates.columns.starts_at'))
                    ->required(fn (Get $get) => $get('use_custom_dates')),
                DatePicker::make('ends_at')
                    ->visible(fn (Get $get) => $get('use_custom_dates'))
                    ->label(trans('filament-subscriptions::messages.subscriptions.sections.custom_dates.columns.ends_at'))
                    ->required(fn (Get $get) => $get('use_custom_dates')),
                DatePicker::make('canceled_at')
                    ->visible(fn (Get $get) => $get('use_custom_dates'))
                    ->label(trans('filament-subscriptions::messages.subscriptions.sections.custom_dates.columns.canceled_at'))
                    ->required(fn (Get $get) => $get('use_custom_dates')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subscriber.name')
                    ->label(trans('filament-subscriptions::messages.subscriptions.columns.subscriber'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('plan.name')
                    ->label(trans('filament-subscriptions::messages.subscriptions.columns.plan'))
                    ->sortable()
                    ->searchable(),
                IconColumn::make('active')
                    ->state(function ($record) {
                        return $record->active();
                    })
                    ->boolean()
                    ->label(trans('filament-subscriptions::messages.subscriptions.columns.active'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('trial_ends_at')->dateTime()
                    ->label(trans('filament-subscriptions::messages.subscriptions.columns.trial_ends_at'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('starts_at')->dateTime()
                    ->label(trans('filament-subscriptions::messages.subscriptions.columns.starts_at'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('ends_at')->dateTime()
                    ->label(trans('filament-subscriptions::messages.subscriptions.columns.ends_at'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('canceled_at')->dateTime()
                    ->label(trans('filament-subscriptions::messages.subscriptions.columns.canceled_at'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
            ])
            ->filters([
                TrashedFilter::make(),
                Filter::make(trans('filament-subscriptions::messages.subscriptions.filters.date_range'))
                    ->schema([
                        DatePicker::make('start_date')
                            ->label(trans('filament-subscriptions::messages.subscriptions.filters.start_date'))
                            ->required(),
                        DatePicker::make('end_date')
                            ->label(trans('filament-subscriptions::messages.subscriptions.filters.end_date'))
                            ->required(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (! isset($data['start_date']) || ! isset($data['end_date'])) {
                            return $query;
                        }

                        return $query->whereBetween('starts_at', [$data['start_date'], $data['end_date']]);
                    }),
                Filter::make(trans('filament-subscriptions::messages.subscriptions.filters.canceled'))
                    ->schema([
                        Select::make('canceled')
                            ->options([
                                '' => trans('filament-subscriptions::messages.subscriptions.filters.all'),
                                '1' => trans('filament-subscriptions::messages.subscriptions.filters.yes'),
                                '0' => trans('filament-subscriptions::messages.subscriptions.filters.no'),
                            ])
                            ->label(trans('filament-subscriptions::messages.subscriptions.filters.canceled'))
                            ->required(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (! isset($data['canceled'])) {
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
            ->recordActions([
                EditAction::make()
                    ->tooltip(__('filament-actions::edit.single.label'))
                    ->iconButton(),
                Action::make('cancel')
                    ->visible(fn ($record) => $record->active())
                    ->iconButton()
                    ->label(trans('filament-subscriptions::messages.subscriptions.actions.cancel'))
                    ->tooltip(trans('filament-subscriptions::messages.subscriptions.actions.cancel'))
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->action(function (Model $record) {
                        $record->cancel(true);

                        Notification::make()
                            ->title(trans('filament-subscriptions::messages.notifications.cancel.title'))
                            ->body(trans('filament-subscriptions::messages.notifications.cancel.message'))
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation(),
                Action::make('renew')
                    ->visible(fn ($record) => $record->ended())
                    ->iconButton()
                    ->label(trans('filament-subscriptions::messages.subscriptions.actions.renew'))
                    ->tooltip(trans('filament-subscriptions::messages.subscriptions.actions.renew'))
                    ->icon('heroicon-o-arrow-path-rounded-square')
                    ->color('info')
                    ->action(function (Model $record) {
                        // Start a new period. laravel-subscriptions 1.8 dropped the cancels_at column.
                        $record->canceled_at = null;
                        $record->save();
                        $record->renew();

                        Notification::make()
                            ->title(trans('filament-subscriptions::messages.notifications.renew.title'))
                            ->body(trans('filament-subscriptions::messages.notifications.renew.message'))
                            ->success()
                            ->send();

                    })
                    ->requiresConfirmation(),
                DeleteAction::make()
                    ->tooltip(__('filament-actions::delete.single.label'))
                    ->iconButton(),
                ForceDeleteAction::make()
                    ->tooltip(__('filament-actions::force-delete.single.label'))
                    ->iconButton(),
                RestoreAction::make()
                    ->tooltip(__('filament-actions::restore.single.label'))
                    ->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
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
            'index' => ListSubscriptions::route('/'),
        ];
    }
}
