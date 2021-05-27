<?php

namespace App\Components\Blade\Forms;

use Bastinald\Malzahar\Components\Blade;
use Bastinald\Malzahar\Components\Html;

class Button extends Blade
{
    public function attributes()
    {
        return [
            'type' => 'button',
        ];
    }

    public function classes()
    {
        return [
            'bg-blue-600 hover:bg-blue-700 text-white rounded-md shadow-sm px-4 py-2',
        ];
    }

    public function template()
    {
        return Html::button($this->slot)
            ->merge($this);
    }
}
