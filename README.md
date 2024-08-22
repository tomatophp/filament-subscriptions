![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-subscriptions/master/arts/megoxv-tomato-subscriptions.jpg)

# Filament Subscriptions

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-subscriptions/version.svg)](https://packagist.org/packages/tomatophp/filament-subscriptions)
[![PHP Version Require](http://poser.pugx.org/tomatophp/filament-subscriptions/require/php)](https://packagist.org/packages/tomatophp/filament-subscriptions)
[![License](https://poser.pugx.org/tomatophp/filament-subscriptions/license.svg)](https://packagist.org/packages/tomatophp/filament-subscriptions)
[![Downloads](https://poser.pugx.org/tomatophp/filament-subscriptions/d/total.svg)](https://packagist.org/packages/tomatophp/filament-subscriptions)

Manage subscriptions and feature access with customizable plans in FilamentPHP

## Installation

```bash
composer require tomatophp/filament-subscriptions
```
after install your package please run this command

```bash
php artisan filament-subscriptions:install
```

finally register the plugin on `/app/Providers/Filament/AdminPanelProvider.php`

```php
->plugin(\TomatoPHP\FilamentSubscriptions\FilamentSubscriptionsPlugin::make())
```

## Configuration

To configure the billing provider for your application, use the `FilamentSubscriptionsProvider`:

```php
use TomatoPHP\FilamentSubscriptions\Providers\FilamentSubscriptionsProvider;
use Filament\Panel;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->tenantBillingProvider(new FilamentSubscriptionsProvider());
}
```

This setup allows users to manage their billing through a link in the tenant menu.

## Requiring a Subscription

To enforce a subscription requirement for any part of your application, use the `requiresTenantSubscription()` method:

```php
use Filament\Panel;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->requiresTenantSubscription();
}
```

Users without an active subscription will be redirected to the billing page.

## Publish Assets

you can publish config file by use this command

```bash
php artisan vendor:publish --tag="filament-subscriptions-config"
```

you can publish views file by use this command

```bash
php artisan vendor:publish --tag="filament-subscriptions-views"
```

you can publish languages file by use this command

```bash
php artisan vendor:publish --tag="filament-subscriptions-lang"
```

## Support

you can join our discord server to get support [TomatoPHP](https://discord.gg/vKV9U7gD3c)

## Docs

you can check docs of this package on [Docs](https://docs.tomatophp.com/filament/filament-withdrawals)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

Please see [SECURITY](SECURITY.md) for more information about security.

## Credits

- [Abdelmjid](https://wa.me/201091523908)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


