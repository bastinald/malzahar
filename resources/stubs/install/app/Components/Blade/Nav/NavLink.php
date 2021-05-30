<?php

namespace App\Components\Blade\Nav;

use Illuminate\Support\Facades\Route;
use Bastinald\Malzahar\Components\Html;
use Illuminate\Routing\Route as Router;
use Bastinald\Malzahar\Components\Blade;
use Bastinald\Malzahar\Components\Dynamic;

class NavLink extends Blade
{
    /**
     * Local icon property.
     *
     * @var string
     */
    public ?string $icon; 
    
    /**
     * Local route property.
     *
     * @var \Illuminate\Routing\Route
     */
    public Router $route;
    
    /**
     * Local title property.
     *
     * @var string|null
     */
    public ?string $title;

    /**
     * Navlink attributes array.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name' => 'heroicon-o-' . $this->icon,
        ];
    }

    /**
     * Navlink classes array.
     *
     * @return array
     */
    public function classes(): array
    {
        return [
            'w-6 h-6',
            'text-gray-600 hover:text-black' => Route::currentRouteName() != $this->route,
            'text-blue-600' => Route::currentRouteName() == $this->route,
        ];
    }

    /**
     * Return our nav link component template.
     *
     * @return \Bastinald\Malzahar\Components\Html
     */
    public function template(): Html
    {
        return Html::a(
            Dynamic::icon()->merge($this),
        )->href(route($this->route))->title($this->title);
    }
}
