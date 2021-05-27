<?php

namespace Bastinald\Malzahar\Commands;

use Bastinald\Malzahar\Traits\MakesStubs;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Livewire\Commands\ComponentParser;

class LivewireCommand extends Command
{
    use MakesStubs;

    protected $signature = 'malz:livewire {class} {--f}';

    public function handle()
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
    }
}
