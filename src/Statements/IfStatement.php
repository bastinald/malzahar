<?php

namespace Bastinald\Malzahar\Statements;

use Closure;

class IfStatement
{
    /**
     * Local conditions array.
     *
     * @var array
     */
    public array $conditions = [];

    /**
     * Create a new instance of the class.
     *
     * @param bool|null $condition
     * @param \Closure $callback
     */
    public function __construct(?bool $condition, Closure $callback)
    {
        $this->conditions[] = [$condition, $callback];
    }

    /**
     * Else if condition handler.
     *
     * @param  bool|null $condition
     * @param  \Closure $callback
     * @return \Bastinald\Malzahar\Statements\IfStatement
     */
    public function elseif(?bool $condition, Closure $callback): IfStatement
    {
        $this->conditions[] = [$condition, $callback];

        return $this;
    }

    /**
     * Else conditions handler.
     *
     * @param  \Closure $callback
     * @return \Bastinald\Malzahar\Statements\IfStatement
     */
    public function else(Closure $callback): IfStatement
    {
        $this->conditions[] = [true, $callback];

        return $this;
    }

    /**
     * Loop conditions and execute the callback.
     *
     * @return string
     */
    public function __toString(): string
    {
        foreach ($this->conditions as $condition) {
            if ($condition[0]) {
                $callback = $condition[1];
                
                return $callback();
            }
        }

        return '';
    }
}
