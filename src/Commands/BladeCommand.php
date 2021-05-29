<?php

namespace Bastinald\Malzahar\Commands;

use Illuminate\Console\Command;
use Livewire\Commands\ComponentParser;
use Bastinald\Malzahar\Traits\MakesStubs;

class BladeCommand extends Command
{
    use MakesStubs;

    /**
     * Command signature.
     * 
     * @var string
     */
    protected $signature = 'malz:blade {class}';

    /**
     * Execute the given command.
     *  
     * @return int
     */
    public function handle(): int
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

        return 0;
    }
}
