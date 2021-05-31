<?php

namespace Bastinald\Malzahar\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class MalzaharProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/malzahar.php', 'malzahar');

        // TODO: register bindings maybe
        
    }
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->setConfiguration(
            config('malzahar.namespace'),
            config('malzahar.path'),
            config('malzahar.layout')
        );

        $this->configurePublishing();
        $this->configureCommands();
        $this->loadRoutesViews();
    }

    /**
     * Set live configuration paths from config.
     *
     * @param  string $class
     * @param  string $path
     * @param  string $layout
     * @return void
     */
    protected function setConfiguration($class, $path, $layout): void
    {
        Config::set('livewire.class_namespace', $class);
        Config::set('livewire.view_path', $path);
        Config::set('livewire.layout', $layout);
    }

    /**
     * Configure publishing for the package.
     *
     * @return void
     */
    protected function configurePublishing(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }
        
        $this->publishes([
            __DIR__.'/../../config/malzahar.php' => config_path('malzahar.php'),
        ], 'malzahar-config');

        if (! is_dir($stubsPath = base_path('stubs'))) {
            (new Filesystem)->makeDirectory($stubsPath);
        }

        $this->publishes([
            __DIR__.'/../../resources/stubs/components/blade.stub' => $stubsPath . '/components/blade.stub',
            __DIR__.'/../../resources/stubs/components/livewire-full.stub' => $stubsPath . '/components/livewire_full.stub',
            __DIR__.'/../../resources/stubs/components/livewire-partial.stub' => $stubsPath . '/components/livewire-partial.stub',
            __DIR__.'/../../resources/stubs/models/factory.stub' => $stubsPath . '/models/factory.stub',
            __DIR__.'/../../resources/stubs/models/model.stub' => $stubsPath . '/models/model.stub',
            __DIR__.'/../../resources/stubs/models/user-factory.stub' => $stubsPath . '/models/user-factory.stub',
            __DIR__.'/../../resources/stubs/models/user-model.stub' => $stubsPath . '/models/user-model.stub',
        ], 'malzahar-stubs');
    }

    /**
     * Configure the commands offered by the application.
     *
     * @return void
     */
    protected function configureCommands(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            \Bastinald\Malzahar\Commands\BladeCommand::class,
            \Bastinald\Malzahar\Commands\InstallCommand::class,
            \Bastinald\Malzahar\Commands\LivewireCommand::class,
            \Bastinald\Malzahar\Commands\MigrateCommand::class,
            \Bastinald\Malzahar\Commands\ModelCommand::class,
        ]);
    }

    /**
     * Load package routes and views.
     *
     * @return void
     */
    protected function loadRoutesViews(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'malzahar');
    }
}
