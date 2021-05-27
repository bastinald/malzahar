<?php

namespace Bastinald\Malzahar\Components;

use Livewire\Component;

class Livewire extends Component
{
    public static function make()
    {
        return Dynamic::livewire(static::getName());
    }

    public function route()
    {
        return null;
    }

    public function title()
    {
        return null;
    }

    public function error($key)
    {
        return $this->getErrorBag()->get($key)[0] ?? null;
    }

    public function render()
    {
        return <<<'blade'
            @section('title', $this->title())
            {!! $this->template() !!}
        blade;
    }
}
