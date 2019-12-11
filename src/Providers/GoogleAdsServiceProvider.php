<?php

namespace BADDIGroup\GoogleAds\Providers;

use BADDIGroup\GoogleAds\Console\RefreshTokenCommand;
use BADDIGroup\GoogleAds\GoogleAds;
use Illuminate\Support\ServiceProvider;

class GoogleAdsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $config_path = function_exists('config_path') ? config_path('googleads.php') : 'googleads.php';

        $this->publishes([
            __DIR__.'/../Config/config.php' => $config_path,
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Console commands
        $this->commands([
            RefreshTokenCommand::class,
        ]);

        $this->app->bind(GoogleAds::class, function ($app) {
            return new GoogleAds();
        });

    }
}
