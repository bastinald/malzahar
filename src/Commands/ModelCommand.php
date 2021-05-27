<?php

namespace Bastinald\Malzahar\Commands;

use Bastinald\Malzahar\Traits\MakesStubs;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Livewire\Commands\ComponentParser;

class ModelCommand extends Command
{
    use MakesStubs;

    protected $signature = 'malz:model {class}';

    public function handle()
    {
        $modelParser = new ComponentParser(
            'App\\Models',
            config('livewire.view_path'),
            $this->argument('class')
        );
        $factoryParser = new ComponentParser(
            'Database\\Factories',
            config('livewire.view_path'),
            $this->argument('class') . 'Factory'
        );

        $replaces = [
            'DummyModelNamespace' => $modelParser->classNamespace(),
            'DummyModelClass' => $modelParser->className(),
            'DummyFactoryNamespace' => $factoryParser->classNamespace(),
            'DummyFactoryClass' => $factoryParser->className(),
        ];

        if (Str::lower($this->argument('class')) == 'user') {
            $prefix = 'user-';
            $filesystem = new Filesystem;
            $migration = database_path('migrations/2014_10_12_000000_create_users_table.php');

            if ($filesystem->exists($migration)) {
                $filesystem->delete($migration);
            }
        }

        $this->makeStub(
            $modelParser->classPath(),
            'models/' . ($prefix ?? null) . 'model.stub',
            $replaces
        );
        $this->makeStub(
            Str::replaceFirst('app/', '', $factoryParser->classPath()),
            'models/' . ($prefix ?? null) . 'factory.stub',
            $replaces
        );

        $this->info('Model & factory created!');
    }
}
