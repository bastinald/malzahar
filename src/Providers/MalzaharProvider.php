<?php

namespace Bastinald\Malzahar\Providers;

use Bastinald\Malzahar\Commands\BladeCommand;
use Bastinald\Malzahar\Commands\InstallCommand;
use Bastinald\Malzahar\Commands\LivewireCommand;
use Bastinald\Malzahar\Commands\MigrateCommand;
use Bastinald\Malzahar\Commands\ModelCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class MalzaharProvider extends ServiceProvider
{
    public function boot()
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
