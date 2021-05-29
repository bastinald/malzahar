<?php

namespace App\Components\Blade\Forms;

use Bastinald\Malzahar\Components\Blade;
use Bastinald\Malzahar\Components\Html;

class Button extends Blade
{
    /**
     * Array of button attributes.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'type' => 'button',
        ];
    }

    /**
     * Array of button classes. 
     *
     * @return array
     */
    public function classes(): array
    {
        return [
            'bg-blue-600 hover:bg-blue-700 text-white rounded-md shadow-sm px-4 py-2',
        ];
    }

    /**
     * Return our button component template.
     *
     * @return \Bastinald\Malzahar\Components\Html
     */
    public function template(): Html
    {
        return Html::button($this->slot)
            ->merge($this);
    }
}
