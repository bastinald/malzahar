<?php

namespace App\Components\Blade\Layouts;

use App\Components\Blade\Nav\NavMenu;
use Bastinald\Malzahar\Components\Blade;
use Bastinald\Malzahar\Components\Html;

class AuthLayout extends Blade
{
    public function template()
    {
        return Html::div(
            Html::header(
                Html::div(
                    Html::img()
                        ->src(asset('images/logo.png'))
                        ->class('h-8'),

                    NavMenu::make(),
                )->class('flex justify-between items-center w-full max-w-3xl mx-auto'),
            )->class('bg-white shadow px-5 py-3'),

            Html::main(
                Html::div($this->slot)
                    ->class('w-full max-w-3xl mx-auto'),
            )->class('p-5'),
        )->class('bg-gray-200 min-h-screen');
    }
}
