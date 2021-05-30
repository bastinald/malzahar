<?php

namespace Bastinald\Malzahar\Statements;

use Bastinald\Malzahar\Contracts\ComponentInterface;

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
     * @param \Bastinald\Malzahar\Contracts\ComponentInterface ...$slot
     */
    public function __construct(?bool $condition, ComponentInterface ...$slot)
    {
        $this->conditions[$condition] = implode($slot);
    }

    /**
     * Else if condition handler.
     *
     * @param  bool|null $condition
     * @param  \Bastinald\Malzahar\Contracts\ComponentInterface ...$slot
     * @return \Bastinald\Malzahar\Statements\IfStatement
     */
    public function elseif(?bool $condition, ComponentInterface ...$slot): IfStatement
    {
        $this->conditions[$condition] = implode($slot);
        
        return $this;
    }

    /**
     * Else conditions handler.
     *
     * @param  \Bastinald\Malzahar\Contracts\ComponentInterface ...$slot
     * @return \Bastinald\Malzahar\Statements\IfStatement
     */
    public function else(ComponentInterface ...$slot): IfStatement
    {
        $condition = $this->findOrFail();
        
        $this->conditions[$condition] = implode($slot);

        return $this;
    }

    /**
     * Determine if the else condition should be set to true or false.
     *
     * @return boolean
     */
    public function findOrFail(): bool
    {
        foreach ($this->conditions as $key => $condition) {
            if ($key) {
                return false;
            }
        }

        return true;
    }

    /**
     * Return slot as a string.
     *
     * @return string
     */
    public function __toString(): string
    {
        foreach ($this->conditions as $condition => $slot) {
            if ($condition) {
                return $slot;
            }
        }

        return '';
    }
}
