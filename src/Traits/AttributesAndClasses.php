<?php

namespace Bastinald\Malzahar\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;

trait AttributesAndClasses
{
    public $attributes;

    public function __construct()
    {
        $this->attributes = new ComponentAttributeBag;
    }

    public function attribute($attribute, $value)
    {
        if (Str::startsWith($attribute, 'wire')) {
            $attribute = Str::replaceFirst('wire.', 'wire:', Str::snake($attribute, '.'));
        } else if (Str::startsWith($attribute, 'x')) {
            $attribute = Str::snake($attribute, '~');
            $attribute = Str::replaceFirst('~', '-', $attribute);
            $attribute = Str::replaceFirst('~', ':', $attribute);
            $attribute = Str::replace('~', Str::startsWith($attribute, 'x-on') ? '.' : '-', $attribute);
        }

        $this->attributes[$attribute] = $value[0] ?? true;

        return $this;
    }

    public function attributes()
    {
        return [];
    }

    public function class($class)
    {
        $this->attributes['class'] = $class;

        return $this;
    }

    public function classes()
    {
        return [];
    }

    public function merge($component)
    {
        $this->attributes = $this->attributes
            ->class(array_merge(
                $component->classes(),
                Arr::wrap($component->attributes->get('class')),
            ))
            ->merge(array_merge(
                $component->attributes(),
                $component->attributes->getAttributes(),
            ));

        return $this;
    }
}
