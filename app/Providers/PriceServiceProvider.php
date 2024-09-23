<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PriceService;

class PriceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        // تسجيل PriceService في الحاوية
        $this->app->singleton(PriceService::class, function ($app) {
            return new PriceService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
