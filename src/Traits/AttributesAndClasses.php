<?php

namespace Bastinald\Malzahar\Traits;

use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;

trait AttributesAndClasses
{   
    /**
     * Local attributes property.
     * 
     * @var array
     */
    public ComponentAttributeBag $attributes;

    /**
     * Create a new instance of the class.
     */
    public function __construct()
    {
        $this->attributes = new ComponentAttributeBag;
    }

    /**
     * set an attribute to our attributes array.
     *
     * @param  string $attribute
     * @param  array $value
     * @return \Bastinald\Malzahar\Traits\AttributesAndClasses
     */
    public function attribute($attribute, $value): AttributesAndClasses
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

    /**
     * Return and array of attributes.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [];
    }

    /**
     * Set a class attribute.
     *
     * @param  string $class
     * @return \Bastinald\Malzahar\Traits\AttributesAndClasses
     */
    public function class($class): AttributesAndClasses
    {
        $this->attributes['class'] = $class;

        return $this;
    }

    /**
     * Return an array of classes.
     *
     * @return array
     */
    public function classes(): array
    {
        return [];
    }

    /**
     * Merge attributes and classes into components.
     *
     * @param  mixed $component
     * @return void
     */
    public function merge($component): mixed
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
