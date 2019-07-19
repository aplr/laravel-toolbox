<?php

namespace Aplr\Toolbox;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Contracts\Container\Container;

use Illuminate\Support\Facades\Blade;

use Doctrine\DBAL\Types\Type;

class ServiceProvider extends LaravelServiceProvider
{
    
    public function register()
    {
        $this->registerToolbox();

        $this->registerUniq();
    }

    public function boot()
    {
        $this->publishes([
            $this->configPath() => config_path('toolbox.php')
        ]);

        $this->registerBladeDirectives();

        $this->registerDbalTypes();
    }

    protected function registerDbalTypes()
    {
        if (!Type::hasType('uuid')) {
            Type::addType('uuid', \Aplr\Toolbox\Database\DBAL\UuidType::class);
        }

        if (!Type::hasType('char')) {
            Type::addType('char', \Aplr\Toolbox\Database\DBAL\CharType::class);
        }
    }

    protected function registerToolbox()
    {
        $this->mergeConfigFrom($this->configPath(), 'toolbox');

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
        $this->app->singleton('uniq', function (Container $app) {
            return new Uniq($app['config']['toolbox']);
        });
    }
    
    protected function configPath()
    {
        return __DIR__ . '/../config/toolbox.php';
    }
    
    public function provides()
    {
        return [
            'toolbox', 'uniq'
        ];
    }
}
