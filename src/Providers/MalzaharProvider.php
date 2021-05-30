<?php

namespace Bastinald\Malzahar\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Bastinald\Malzahar\Commands\BladeCommand;
use Bastinald\Malzahar\Commands\ModelCommand;
use Bastinald\Malzahar\Commands\InstallCommand;
use Bastinald\Malzahar\Commands\MigrateCommand;
use Bastinald\Malzahar\Commands\LivewireCommand;

class MalzaharProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */ 
    public function boot(): void
    {
        Config::set('livewire.class_namespace', 'App\\Components\\Livewire');
        Config::set('livewire.view_path', resource_path('views'));
        Config::set('livewire.layout', 'malzahar::layout');

        if ($this->app->runningInConsole()) {
            $this->commands([
                BladeCommand::class,
                InstallCommand::class,
                LivewireCommand::class,
                MigrateCommand::class,
                ModelCommand::class,
            ]);
        }

        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'malzahar');
    }
}
