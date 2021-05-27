<?php

namespace Bastinald\Malzahar\Components;

use Bastinald\Malzahar\Traits\AttributesAndClasses;
use Illuminate\Support\Str;
use Livewire\CreateBladeView;

class Dynamic
{
    use AttributesAndClasses;

    public $component, $name;

    public static function __callStatic($attribute, $value)
    {
        $dynamic = new static;
        $dynamic->component = Str::snake($attribute, '-');
        $dynamic->name = $value[0] ?? null;

        return $dynamic;
    }

    public function __call($attribute, $value)
    {
        return $this->attribute($attribute, $value);
    }

    public function __toString()
    {
        if ($this->component == 'livewire') {
            $string = '<livewire:' . $this->name . ' ' . $this->attributes . '/>';
        } else {
            $string = '<x-dynamic-component component="' . $this->component . '" ' . $this->attributes . '/>';
        }

        return view(CreateBladeView::fromString($string))->render();
    }
}
