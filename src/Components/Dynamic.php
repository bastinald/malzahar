<?php

namespace Bastinald\Malzahar\Components;

use Illuminate\Support\Str;
use Livewire\CreateBladeView;
use Bastinald\Malzahar\Traits\AttributesAndClasses;

class Dynamic
{
    use AttributesAndClasses;

    /**
     * Local component property.
     * 
     * @var mixed
     */
    public $component;
    
    /**
     * Local name property.
     * 
     * @var string|null
     */
    public ?string $name;

    /**
     * Statically generate a new instance of the class.
     *
     * @param  mixed $attribute
     * @param  array $value
     * @return \Bastinald\Malzahar\Components\Dynamic
     */
    public static function __callStatic(string $attribute, array $value): Dynamic
    {
        $dynamic = new static;
        $dynamic->component = Str::snake($attribute, '-');
        $dynamic->name = $value[0] ?? null;

        return $dynamic;
    }

    /**
     * Set and return an attribute.
     *
     * @param  string $attribute
     * @param  array $value
     * @return mixed
     */
    public function __call(string $attribute, array $value): mixed
    {
        return $this->attribute($attribute, $value);
    }

    /**
     * Return a string instance of a blade template.
     *
     * @return string
     */
    public function __toString(): string
    {
        if ($this->component == 'livewire') {
            $string = '<livewire:' . $this->name . ' ' . $this->attributes . '/>';
        } else {
            $string = '<x-dynamic-component component="' . $this->component . '" ' . $this->attributes . '/>';
        }

        return view(CreateBladeView::fromString($string))->render();
    }
}
