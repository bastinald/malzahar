<?php

namespace App\Components\Blade\Forms;

use Bastinald\Malzahar\Components\Html;
use Bastinald\Malzahar\Components\Blade;
use Bastinald\Malzahar\Statements\Statement;

class Input extends Blade
{
    /**
     * Input label property.
     * 
     * @var string
     */
    public string $label;
    
    /**
     * Input error property.
     * 
     * @var string|null
     */
    public ?string $error;

    /**
     * Input attributes array.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'type' => $type = $this->attributes->get('type', 'text'),
            'inputmode' => $type == 'number' ? 'numeric' : $type,
        ];
    }

    /**
     * Input classes array.
     *
     * @return array
     */
    public function classes(): array
    {
        return [
            'rounded-md shadow-sm w-full',
            'border-gray-300' => !$this->error,
            'border-red-600' => $this->error,
        ];
    }

    /**
     * Return our input component template.
     *
     * @return \Bastinald\Malzahar\Components\Html
     */
    public function template(): Html
    {
        return Html::div(
            Statement::if($this->label,
                fn() => Html::label($this->label),
            ),

            Html::input()
                ->merge($this),

            Statement::if($this->error,
                fn() => Html::p($this->error)
                    ->class('text-red-600 text-sm'),
            ),
        )->class('space-y-1 mb-5');
    }
}
