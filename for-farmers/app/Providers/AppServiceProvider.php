<?php

namespace App\Providers;
use Illuminate\Support\Facades\App; // 追加
use Illuminate\Support\Facades\URL; // 追加
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
        if (App::environment('production','staging')) {
            URL::forceScheme('https');
        }
    }
}
