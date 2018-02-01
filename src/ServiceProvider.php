<?php 

namespace Aplr\Toolbox;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Contracts\Container\Container;

class ServiceProvider extends LaravelServiceProvider {
    
    public function register()
    {
        $this->registerToolbox();
    }

    protected function registerToolbox()
    {
        $this->app->singleton('toolbox', function (Container $app) {
            return new Toolbox;
        });
    }
    
    public function provides()
    {
        return [
            'toolbox'
        ];
    }
    
}