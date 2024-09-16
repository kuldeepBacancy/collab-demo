<?php

namespace App\Providers;

use App\AvatarProviders\CustomAvatarProvider;
use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Filament\AvatarProviders\Contracts\AvatarProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
