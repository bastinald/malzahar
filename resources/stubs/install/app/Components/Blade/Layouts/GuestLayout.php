<?php

namespace App\Components\Blade\Layouts;

use Bastinald\Malzahar\Components\Blade;
use Bastinald\Malzahar\Components\Html;

class GuestLayout extends Blade
{
    public function template()
    {
        return Html::div(
            Html::img()
                ->src(asset('images/logo.png'))
                ->class('h-12 mb-4'),

            Html::div($this->slot)
                ->class('bg-white rounded-lg shadow w-full max-w-xs p-7 mb-14'),
        )->class('flex flex-col justify-center items-center bg-gray-200 min-h-screen p-5');
    }
}
