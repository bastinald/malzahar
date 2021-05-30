<?php

namespace Bastinald\Malzahar\Components;

use Bastinald\Malzahar\Traits\AttributesAndClasses;
use Bastinald\Malzahar\Contracts\ComponentInterface;

class Html implements ComponentInterface 
{
    use AttributesAndClasses;

    /**
     * local tag property.
     * 
     * @var string
     */
    public string $tag;
    
    /**
     * Local slot property.
     * 
     * @var string
     */
    public string $slot;

    /**
     * Statically create a new instance of the class.
     *
     * @param  string $attribute
     * @param  array $value
     * @return \Bastinald\Malzahar\Components\Html
     */
    public static function __callStatic(string $attribute, array $value): Html
    {
        $html = new static;
        $html->tag = $attribute;
        $html->slot = implode($value);

        return $html;
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
     * Return a string instance of the template.
     *
     * @return string
     */
    public function __toString(): string
    {
        $string = '<' . $this->tag . ' ' . $this->attributes . '>';
        $string .= $this->slot;

        if (!in_array($this->tag, [
            'area', 'base', 'basefont', 'bgsound', 'br', 'col', 'command', 'embed',
            'frame', 'hr', 'image', 'img', 'input', 'isindex', 'keygen', 'link',
            'menuitem', 'meta', 'nextid', 'param', 'source', 'track', 'wbr'
        ])) {
            $string .= '</' . $this->tag . '>';
        }

        return $string;
    }
}
