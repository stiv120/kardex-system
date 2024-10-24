<?php

namespace App\Providers;

use App\Models\KardexMovement;
use Illuminate\Support\ServiceProvider;
use Src\KardexMovement\Infrastructure\Observers\KardexMovementObserver;

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
        KardexMovement::observe(KardexMovementObserver::class);
    }
}
