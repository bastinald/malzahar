<?php

namespace App\Components\Blade\Nav;

use Bastinald\Malzahar\Components\Blade;
use Bastinald\Malzahar\Components\Dynamic;
use Bastinald\Malzahar\Components\Html;
use Illuminate\Support\Facades\Route;

class NavLink extends Blade
{
    public $icon, $route, $title;

    public function attributes()
    {
        return [
            'name' => 'heroicon-o-' . $this->icon,
        ];
    }

    public function classes()
    {
        return [
            'w-6 h-6',
            'text-gray-600 hover:text-black' => Route::currentRouteName() != $this->route,
            'text-blue-600' => Route::currentRouteName() == $this->route,
        ];
    }

    public function template()
    {
        return Html::a(
            Dynamic::icon()->merge($this),
        )->href(route($this->route))->title($this->title);
    }
}
