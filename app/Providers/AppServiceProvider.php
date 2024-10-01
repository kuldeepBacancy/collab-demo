<?php

namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

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
        /* Arr macro to check the array/value is set or not */
        Arr::macro('hasNotNull', function ($arrList, $keyList) {
            if (Arr::has($arrList, $keyList)) {
                if (is_array($keyList)) {
                    foreach ($keyList as $keyItem) {
                        if (empty(Arr::get($arrList, $keyItem)) || is_null(Arr::get($arrList, $keyItem))) {
                            return false;
                        }
                    }
                } else {
                    if (empty(Arr::get($arrList, $keyList)) || is_null(Arr::get($arrList, $keyList))) {
                        return false;
                    }
                }
            } else {
                return false;
            }

            return true;
        });
    }
}
