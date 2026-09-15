<?php

namespace TomatoPHP\FilamentSubscriptions\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use TomatoPHP\ConsoleHelpers\Traits\RunCommand;
use TomatoPHP\FilamentSubscriptions\Models\Plan;

class FilamentSubscriptionInstall extends Command
{
    use RunCommand;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'filament-subscriptions:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install package and publish assets';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Publish Vendor Assets');

        // Migrate first: the main plan lives in the laravel-subscriptions plans table.
        $this->artisanCommand(['migrate']);

        if (! Schema::hasTable((new Plan)->getTable())) {
            $this->error('The plans table does not exist. Publish the laravel-subscriptions migrations first:');
            $this->line('php artisan vendor:publish --provider="Laravelcm\Subscriptions\SubscriptionServiceProvider"');

            return self::FAILURE;
        }

        if (! Plan::query()->where('slug', 'main')->exists()) {
            $plan = new Plan;
            $plan->name = 'Main';
            $plan->slug = 'main';
            $plan->price = 0;
            $plan->currency = 'USD';
            $plan->is_active = true;
            $plan->trial_period = 1264;
            $plan->trial_interval = 'year';
            $plan->save();
        }

        $this->artisanCommand(['optimize:clear']);
        $this->info('Filament Subscription installed successfully.');

        return self::SUCCESS;
    }
}
