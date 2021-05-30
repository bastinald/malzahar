<?php

namespace App\Components\Blade\Layouts;

use Bastinald\Malzahar\Components\Html;
use Bastinald\Malzahar\Components\Blade;

class GuestLayout extends Blade
{
    /**
     * Return our guest layout template.
     *
     * @return \Bastinald\Malzahar\Components\Html
     */
    public function template(): Html
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
