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
}
