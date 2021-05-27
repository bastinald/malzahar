<?php

namespace App\Components\Blade\Nav;

use Bastinald\Malzahar\Components\Blade;
use Bastinald\Malzahar\Components\Html;

class NavMenu extends Blade
{
    public function classes()
    {
        return [
            'flex space-x-3',
        ];
    }

    public function template()
    {
        return Html::nav(
            NavLink::make()->icon('home')->route('home')->title(__('Home')),
            NavLink::make()->icon('logout')->route('logout')->title(__('Logout')),
        )->merge($this);
    }
}
