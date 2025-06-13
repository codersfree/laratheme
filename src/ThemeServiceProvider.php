<?php

namespace CodersFree\Laratheme;

use CodersFree\Laratheme\Console\Commands\MakeThemeCommand;
use CodersFree\Laratheme\Services\ThemeService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Termwind\Components\Dd;

class ThemeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/theme.php',
            'theme'
        );

        $this->commands([
            MakeThemeCommand::class,
        ]);

        $this->app->singleton('theme', function ($app) {
            return new ThemeService($app['view'], $app['url']);
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/theme.php' => config_path('theme.php'),
        ], 'theme-config');

        $this->publishes([
            __DIR__ . '/../stubs' => config('theme.paths.stubs'),
        ], 'theme-stubs');

        //Agregar namespacio para las vistas del tema activo
        View::addNamespace('theme', config('theme.paths.views') . '/' . config('theme.active'));
    }
}