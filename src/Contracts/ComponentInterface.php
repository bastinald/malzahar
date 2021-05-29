<?php 

namespace Bastinald\Malzahar\Contracts;

interface ComponentInterface 
{
    /**
     * Set and return an attribute.
     *
     * @param  string $attribute
     * @param  array $value
     * @return mixed
     */
    public function __call(string $attribute, array $value): mixed;
}
