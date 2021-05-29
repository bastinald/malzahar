<?php

namespace Bastinald\Malzahar\Statements;

class Statement
{
    /**
     * Statically call IfStatement handler.
     *
     * @param  string $condition
     * @param  array ...$slot
     * @return \Bastinald\Malzahar\Statements\IfStatement
     */
    public static function if($condition, ...$slot): IfStatement
    {
        return new IfStatement($condition, ...$slot);
    }

    /**
     * Statically call EachStatement handler.
     *
     * @param  string $items
     * @param  array $closure
     * @return \Bastinald\Malzahar\Statements\EachStatement
     */
    public static function each($items, $closure): EachStatement
    {
        return new EachStatement($items, $closure);
    }
}
