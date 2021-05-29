<?php

namespace Bastinald\Malzahar\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Livewire\Commands\ComponentParser;
use Bastinald\Malzahar\Traits\MakesStubs;

class ModelCommand extends Command
{
    use MakesStubs;

    /**
     * Command signature.
     * 
     * @var string
     */
    protected $signature = 'malz:model {class}';

    /**
     * Execute the given command.
     * 
     * @return int
     */
    public function handle(): int
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

        return 0;
    }
}
