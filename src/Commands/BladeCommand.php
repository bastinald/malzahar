<?php

namespace Bastinald\Malzahar\Commands;

use Bastinald\Malzahar\Traits\MakesStubs;
use Illuminate\Console\Command;
use Livewire\Commands\ComponentParser;

class BladeCommand extends Command
{
    use MakesStubs;

    protected $signature = 'malz:blade {class}';

    public function handle()
    {
        $componentParser = new ComponentParser(
            'App\\Components\\Blade',
            config('livewire.view_path'),
            $this->argument('class'),
        );

        $replaces = [
            'DummyBladeNamespace' => $componentParser->classNamespace(),
            'DummyBladeClass' => $componentParser->className(),
        ];

        $this->makeStub(
            $componentParser->classPath(),
            'components/blade.stub',
            $replaces
        );

        $this->info('Blade component created!');
    }
}
