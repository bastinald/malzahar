<?php

namespace Bastinald\Malzahar\Components;

use Bastinald\Malzahar\Traits\AttributesAndClasses;

class Html
{
    use AttributesAndClasses;

    public $tag, $slot;

    public static function __callStatic($attribute, $value)
    {
        $html = new static;
        $html->tag = $attribute;
        $html->slot = implode($value);

        return $html;
    }

    public function __call($attribute, $value)
    {
        return $this->attribute($attribute, $value);
    }

    public function __toString()
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
