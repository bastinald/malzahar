<?php

namespace Bastinald\Malzahar\Statements;

class Statement
{
    public static function if($condition, ...$slot)
    {
        return new IfStatement($condition, ...$slot);
    }

    public static function each($items, $closure)
    {
        return new EachStatement($items, $closure);
    }
}
