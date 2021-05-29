<?php

namespace Bastinald\Malzahar\Components;

use Bastinald\Malzahar\Traits\AttributesAndClasses;

class Blade
{
    use AttributesAndClasses;

    /**
     * Local slot array property.
     *
     * @var string
     */
    public string $slot;

    /**
     * Generate and return a slotted instance.
     * 
     * @param  mixed $slot
     * @return \Bastinald\Malzahar\Components\Blade
     */
    public static function make(...$slot): Blade
    {
        $blade = new static;
        $blade->slot = implode($slot);

        return $blade;
    }

    /**
     * Magic call method to set or fetch attributes.
     * 
     * @param  string $attribute
     * @param  array $value
     * @return mixed 
     */
    public function __call(string $attribute, array $value): mixed
    {
        if (property_exists($this, $attribute)) {
            $this->$attribute = $value[0] ?? null;

            return $this;
        }

        return $this->attribute($attribute, $value);
    }

    /**
     * Return a string instance of the template.
     * 
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->template();
    }
}
