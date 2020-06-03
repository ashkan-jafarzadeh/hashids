<?php

namespace Hashids;

use Illuminate\Support\ServiceProvider;

class HashidsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        require_once __DIR__ . DIRECTORY_SEPARATOR . "helpers.php";

        $this->registerConfigs();
    }



    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }



    /**
     * register configs, both for autoload and vendor:publish
     *
     * @return void
     */
    private function registerConfigs()
    {
        $original_path = __DIR__ . DIRECTORY_SEPARATOR . 'configs.php';

        $this->mergeConfigFrom($original_path, 'hashids');
        $this->publishes([$original_path => config_path("hashids.php")]);

    }
}
