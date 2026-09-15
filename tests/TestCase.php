<?php

namespace Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Schemas\SchemasServiceProvider;
use Filament\SpatieLaravelSettingsPluginServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravelcm\Subscriptions\SubscriptionServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use Spatie\LaravelSettings\LaravelSettingsServiceProvider;
use Tests\Models\User;
use TomatoPHP\FilamentLocations\FilamentLocationsServiceProvider;
use TomatoPHP\FilamentSettingsHub\FilamentSettingsHubServiceProvider;
use TomatoPHP\FilamentSubscriptions\FilamentSubscriptionsServiceProvider;
use TomatoPHP\FilamentTranslationComponent\FilamentTranslationComponentServiceProvider;

abstract class TestCase extends Orchestra
{
    use RefreshDatabase;
    use WithWorkbench;

    protected function getPackageProviders($app): array
    {
        return [
            ActionsServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            NotificationsServiceProvider::class,
            SchemasServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            LivewireServiceProvider::class,
            LaravelSettingsServiceProvider::class,
            SpatieLaravelSettingsPluginServiceProvider::class,
            FilamentSettingsHubServiceProvider::class,
            FilamentLocationsServiceProvider::class,
            FilamentTranslationComponentServiceProvider::class,
            SubscriptionServiceProvider::class,
            FilamentSubscriptionsServiceProvider::class,
            AdminPanelProvider::class,
        ];
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');

        // laravel-subscriptions only publishes its migrations; the host app runs them.
        $this->loadMigrationsFrom(__DIR__.'/../vendor/laravelcm/laravel-subscriptions/database/migrations');
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('app.key', 'base64:yk+bUVuZa1p86Dqjk9OjVK2R1pm6XHxC6xEKFq8utH0=');
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $app['config']->set('auth.providers.users.model', User::class);
    }
}
