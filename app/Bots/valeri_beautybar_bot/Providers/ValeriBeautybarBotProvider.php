<?php

namespace App\Bots\valeri_beautybar_bot\Providers;

use Illuminate\Support\ServiceProvider;

class ValeriBeautybarBotProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'valeri_beautybar_bot');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'valeri_beautybar_bot');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    // Add the following line to config/app.php in the providers array: 
    // App\Bots\valeri_beautybar_bot\Providers\ValeriBeautybarBotProvider::class,
}
