<?php

namespace App\Bots\VBBeautyBot\Providers;

use Illuminate\Support\ServiceProvider;

class VBBeautyBotProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'VBBeautyBot');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'VBBeautyBot');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    // Add the following line to config/app.php in the providers array: 
    // App\Bots\VBBeautyBot\Providers\VBBeautyBotProvider::class,
}
