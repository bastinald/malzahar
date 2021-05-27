<?php

namespace Bastinald\Malzahar\Statements;

class IfStatement
{
    public $conditions = [];

    public function __construct($condition, ...$slot)
    {
        $this->conditions[$condition] = implode($slot);
    }

    public function elseif($condition, ...$slot)
    {
        $this->conditions[$condition] = implode($slot);

        return $this;
    }

    public function else(...$slot)
    {
        $this->conditions[true] = implode($slot);

        return $this;
    }

    public function __toString()
    {
        foreach ($this->conditions as $condition => $slot) {
            if ($condition) {
                return $slot;
            }
        }

        return '';
    }
}
