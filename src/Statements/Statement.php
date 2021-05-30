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
     * @param  \Closure $callback
     * @return \Bastinald\Malzahar\Statements\IfStatement
     */
    public static function if(?bool $condition, Closure $callback): IfStatement
    {
        return new IfStatement($condition, $callback);
    }

    /**
     * Statically call EachStatement handler.
     *
     * @param  \Illuminate\Support\Collection|array $items
     * @param  \Closure $closure
     * @return \Bastinald\Malzahar\Statements\EachStatement
     */
    public static function each($items, Closure $closure): EachStatement
    {
        if (!$items instanceof Collection) {
            $items = collect($items);
        }
        
        return new EachStatement($items, $closure);
    }
}
