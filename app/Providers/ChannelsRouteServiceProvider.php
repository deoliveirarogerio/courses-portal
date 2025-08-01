<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ChannelsRouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (file_exists(base_path('routes/channels.php'))) {
            $this->loadRoutesFrom(base_path('routes/channels.php'));
        }
    }
}
