<?php

namespace TomatoPHP\FilamentSubscriptions\Console;

use Illuminate\Console\Command;
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

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->info('Publish Vendor Assets');

        $plans = Plan::query()->where('slug', 'main')->first();
        if(!$plans){
            $plans = new Plan();
            $plans->name = 'Main';
            $plans->slug = 'main';
            $plans->price = 0;
            $plans->currency = 'USD';
            $plans->is_active = true;
            $plans->trial_period = 1264;
            $plans->trial_interval = 'year';
            $plans->save();
        }
        $this->artisanCommand(["migrate"]);
        $this->artisanCommand(["optimize:clear"]);
        $this->info('Filament Subscription installed successfully.');
    }
}
