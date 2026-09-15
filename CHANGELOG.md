# Changelog

## v5.0.0

- Support Filament v5 and Laravel 12 / 13 (PHP 8.2+), with laravelcm/laravel-subscriptions ^1.5 (1.8 supports Laravel 13).
- Billing page links and redirects use the panel URL instead of the panel id, thanks to @FabioIYT (#20).
- Billing page works with the configured laravel-subscriptions models and the Filament v5 simple user menu.
- Renewing a subscription no longer writes the `cancels_at` column, which laravel-subscriptions 1.8 removed.
- Editing a plan or a feature fills every translation instead of failing on the translated name.
- The billing page and routes follow the Filament v5 page API.
- Test suite for the plugin, plans, features, subscriptions, billing page, middleware and install command.
