<?php

namespace App\Components\Blade\Nav;

use Bastinald\Malzahar\Components\Html;
use Bastinald\Malzahar\Components\Blade;

class NavMenu extends Blade
{
    /**
     * Navmenu classes array.
     *
     * @return array
     */
    public function classes(): array
    {
        return [
            'flex space-x-3',
        ];
    }

    /**
     * Return the nav menu component template.
     *
     * @return \Bastinald\Malzahar\Components\Html
     */
    public function template(): Html
    {
        return Html::nav(
            NavLink::make()->icon('home')->route('home')->title(__('Home')),
            NavLink::make()->icon('logout')->route('logout')->title(__('Logout')),
        )->merge($this);
    }
}
