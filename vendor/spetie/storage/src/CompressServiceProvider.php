<?php

namespace Spetie\Storage;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Spetie\Storage\Listeners\Compressor;
use Illuminate\Auth\Events\Login;
class CompressServiceProvider extends ServiceProvider
{


    public function register()
    {
       
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
       
        $this->app['events']->listen(Login::class, Compressor::class);      
        

    }
}
