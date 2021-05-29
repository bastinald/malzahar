<?php

namespace Bastinald\Malzahar\Components;

use Livewire\Component;
use Illuminate\Routing\Route as Router;

class Livewire extends Component 
{
    /**
     * Return an instance of the component.
     *
     * @return \Livewire\Component
     */
    public static function make(): Component
    {
        return Dynamic::livewire(static::getName());
    }

    /**
     * Return the route for a full page component.
     *  
     * @return \Illuminate\Routing\Route
     */
    public function route(): ?Router
    {
        return null;
    }

    /**
     * Return a title for a full page component.
     *
     * @return string|null
     */
    public function title(): ?string
    {
        return null;
    }

    /**
     * Return the error for a given key.
     *
     * @param  string $key
     * @return string|null
     */
    public function error(string $key): ?string
    {
        return $this->getErrorBag()->get($key)[0] ?? null;
    }

    /**
     * Return a blade template.
     *
     * @return string
     */
    public function render(): string
    {
        return <<<'blade'
            @section('title', $this->title())
            {!! $this->template() !!}
        blade;
    }
}
