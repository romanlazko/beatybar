<?php

namespace App\Bots\brno_beauty_bar_bot\Providers;

use Illuminate\Support\ServiceProvider;

class BrnoBeautyBarBotProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'brno_beauty_bar_bot');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'brno_beauty_bar_bot');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    // Add the following line to config/app.php in the providers array: 
    // App\Bots\brno_beauty_bar_bot\Providers\BrnoBeautyBarBotProvider::class,
}
