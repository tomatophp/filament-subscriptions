<?php

use Illuminate\Support\Facades\Route;
use TomatoPHP\FilamentSubscriptions\Livewire\Billing;

Route::middleware(['web'])->name('subscription.')->group(function () {
    Route::get('/billing', Billing::class)->name('portal');
});