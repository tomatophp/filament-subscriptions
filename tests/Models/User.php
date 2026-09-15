<?php

namespace Tests\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravelcm\Subscriptions\Traits\HasPlanSubscriptions;
use Tests\Database\Factories\UserFactory;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory;
    use HasPlanSubscriptions;

    protected $table = 'users';

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
