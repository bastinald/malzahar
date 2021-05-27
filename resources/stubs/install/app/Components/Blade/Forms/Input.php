<?php

namespace App\Components\Blade\Forms;

use Bastinald\Malzahar\Components\Blade;
use Bastinald\Malzahar\Components\Html;
use Bastinald\Malzahar\Statements\Statement;

class Input extends Blade
{
    public $label, $error;

    public function attributes()
    {
        return [
            'type' => $type = $this->attributes->get('type', 'text'),
            'inputmode' => $type == 'number' ? 'numeric' : $type,
        ];
    }

    public function classes()
    {
        return [
            'rounded-md shadow-sm w-full',
            'border-gray-300' => !$this->error,
            'border-red-600' => $this->error,
        ];
    }

    public function template()
    {
        return Html::div(
            Statement::if($this->label,
                Html::label($this->label),
            ),

            Html::input()
                ->merge($this),

            Statement::if($this->error,
                Html::p($this->error)
                    ->class('text-red-600 text-sm'),
            ),
        )->class('space-y-1 mb-5');
    }
}
