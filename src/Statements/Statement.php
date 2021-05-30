<?php

namespace Bastinald\Malzahar\Statements;

use Closure;
use Illuminate\Support\Collection;
use Bastinald\Malzahar\Contracts\ComponentInterface;

class Statement
{
    /**
     * Statically call IfStatement handler.
     *
     * @param  bool|null $condition
     * @param  \Bastinald\Malzahar\Contracts\ComponentInterface ...$slot
     * @return \Bastinald\Malzahar\Statements\IfStatement
     */
    public static function if(?bool $condition, ComponentInterface ...$slot): IfStatement
    {
        return new IfStatement($condition, ...$slot);
    }

    /**
     * Statically call EachStatement handler.
     *
     * @param  \Illuminate\Support\Collection $items
     * @param  \Closure $closure
     * @return \Bastinald\Malzahar\Statements\EachStatement
     */
    public static function each(Collection $items, Closure $closure): EachStatement
    {
        return new EachStatement($items, $closure);
    }
}
