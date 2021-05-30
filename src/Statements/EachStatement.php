<?php

namespace Bastinald\Malzahar\Statements;

use Closure;
use Illuminate\Support\Collection;

class EachStatement
{
    public Collection $items;
    
    /**
     * Function to execute when iterating items.
     * 
     * @var \Closure
     */
    public Closure $closure;
    
    /**
     * Function to execute when no iterative items.
     * 
     * @var \Closure
     */
    public Closure $empty;

    /**
     * Create a new instance of the class.
     *
     * @param \Illuminate\Support\Collection $items
     * @param \Closure $closure
     */
    public function __construct(Collection $items, Closure $closure)
    {
        $this->items = $items;
        $this->closure = $closure;
    }

    /**
     * Callback closure to execute when nothing to iterate.
     *
     * @param  \Closure $closure
     * @return void
     */
    public function empty(Closure $closure)
    {
        $this->empty = $closure;

        return $this;
    }

    /**
     * Execute our loop and return as a string.
     *
     * @return string
     */
    public function __toString(): string
    {
        if (count($this->items) == 0) {
            $closure = $this->empty;

            return $closure ? $closure() : '';
        }

        $closure = $this->closure;
        $string = '';

        foreach ($this->items as $key => $item) {
            $string .= $closure($item, $key);
        }

        return $string;
    }
}
