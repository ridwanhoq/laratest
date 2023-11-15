<?php

namespace Ridwanhoq\SimpleBlog\Providers;

use Illuminate\Support\ServiceProvider;

class SimpleBlogServiceProvider extends ServiceProvider
{
    /**
    * Register services.
    *
    */
    public function register(){

    }

    public function boot(){
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'Ridwanhoq/SimpleBlog');
    }

}