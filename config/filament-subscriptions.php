<?php

use TomatoPHP\FilamentSubscriptions\Filament\Pages\Billing;

use TomatoPHP\FilamentSubscriptions\Filament\Resources\PlanResource;
use TomatoPHP\FilamentSubscriptions\Filament\Resources\SubscriptionResource;

return [
   "route" => "/admin/billing",

   'pages' => [
      'billing' => Billing::class,
   ],

   'resources' => [
      'plan' => PlanResource::class,
      'subscription' => SubscriptionResource::class,
   ],
];
