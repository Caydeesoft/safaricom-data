<?php

namespace Caydeesoft\SafaricomData;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class DataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
        {
            App::bind('data', \Caydeesoft\SafaricomData\Libs\Data::class);
            $this->mergeConfigFrom(
                __DIR__ . '/config/data.php', 'data'
            );
        }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/data.php' => config_path('data.php'),
        ]);

    }
}
