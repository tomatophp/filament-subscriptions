<?php

namespace TomatoPHP\FilamentSubscriptions;

use Illuminate\Support\ServiceProvider;


class FilamentSubscriptionsServiceProvider extends ServiceProvider
{
   public function register(): void
   {
      //Register generate command
      $this->commands([
         \TomatoPHP\FilamentSubscriptions\Console\FilamentSubscriptionInstall::class,
      ]);

      //Register Config file
      $this->mergeConfigFrom(__DIR__ . '/../config/filament-subscriptions.php', 'filament-subscriptions');

      //Publish Config
      $this->publishes([
         __DIR__ . '/../config/filament-subscriptions.php' => config_path('filament-subscriptions.php'),
      ], 'filament-subscriptions-config');

      //Register Migrations
      $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

      //Publish Migrations
      $this->publishes([
         __DIR__ . '/../database/migrations' => database_path('migrations'),
      ], 'filament-subscriptions-migrations');
      //Register views
      $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-subscriptions');

      //Publish Views
      $this->publishes([
         __DIR__ . '/../resources/views' => resource_path('views/vendor/filament-subscriptions'),
      ], 'filament-subscriptions-views');

      //Register Langs
      $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'filament-subscriptions');

      //Publish Lang
      $this->publishes([
         __DIR__ . '/../resources/lang' => base_path('lang/vendor/filament-subscriptions'),
      ], 'filament-subscriptions-lang');

      //Register Routes
      $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
   }

   public function boot(): void
   {
      //you boot methods here
   }
}
