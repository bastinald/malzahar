<?php

namespace Bastinald\Malzahar\Components;

use Bastinald\Malzahar\Traits\AttributesAndClasses;

class Blade
{
    use AttributesAndClasses;

    public $slot;

    public static function make(...$slot)
    {
        $blade = new static;
        $blade->slot = implode($slot);

        return $blade;
    }

    public function __call($attribute, $value)
    {
        if (property_exists($this, $attribute)) {
            $this->$attribute = $value[0] ?? null;

            return $this;
        }

        return $this->attribute($attribute, $value);
    }

    public function __toString()
    {
        return (string)$this->template();
    }
}
