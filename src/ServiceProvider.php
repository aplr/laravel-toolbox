<?php 

namespace Aplr\Toolbox;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Contracts\Container\Container;

use Illuminate\Support\Facades\Blade;

class ServiceProvider extends LaravelServiceProvider {
    
    public function register()
    {
        $this->registerToolbox();

        $this->registerUniq();
    }

    public function boot()
    {
        $this->publishes([
            $this->configPath() => config_path('uniq.php')
        ]);

        $this->registerBladeDirectives();
    }

    protected function registerToolbox()
    {
        $this->app->singleton('toolbox', function (Container $app) {
            return new Toolbox;
        });
    }

    protected function registerBladeDirectives()
    {
        Blade::directive('use', function ($expression) {
            return "<?php use $expression; ?>";
        });
    }

    protected function registerUniq()
    {
        $this->mergeConfigFrom($this->configPath(), 'uniq');

        $this->app->singleton('uniq', function (Container $app) {
            return new Uniq($app['config']['uniq']);
        });
    }
    
    protected function configPath()
    {
        return __DIR__ . '/../config/uniq.php';
    }
    
    public function provides()
    {
        return [
            'toolbox', 'uniq'
        ];
    }
    
}