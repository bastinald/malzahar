<?php

namespace Bastinald\Malzahar\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Livewire\Commands\ComponentParser;
use Bastinald\Malzahar\Traits\MakesStubs;

class LivewireCommand extends Command
{
    use MakesStubs;

    /**
     * Command signature.
     * 
     * @var string
     */
    protected $signature = 'malz:livewire {class} {--f}';

    /**
     * Execute the given command.
     * 
     * @return int
     */
    public function handle(): int
    {
        $componentParser = new ComponentParser(
            config('livewire.class_namespace'),
            config('livewire.view_path'),
            $this->argument('class'),
        );

        $replaces = [
            'DummyLivewireNamespace' => $componentParser->classNamespace(),
            'DummyLivewireClass' => $componentParser->className(),
            'DummyRouteUri' => '/' . Str::replace('.', '/', $componentParser->viewName()),
            'DummyRouteName' => $componentParser->viewName(),
            'DummyTitle' => preg_replace('/(.)(?=[A-Z])/u', '$1 ', $componentParser->className()),
            'DummyWisdom' => $componentParser->wisdomOfTheTao(),
        ];

        $this->makeStub(
            $componentParser->classPath(),
            'components/livewire-' . ($this->option('f') ? 'full' : 'partial') . '.stub',
            $replaces
        );

        $this->info('Livewire component created!');

        return 0;
    }
}
