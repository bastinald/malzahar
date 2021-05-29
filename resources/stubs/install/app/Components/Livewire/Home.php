<?php

namespace App\Components\Livewire;

use Illuminate\Support\Facades\Route;
use Bastinald\Malzahar\Components\Html;
use Illuminate\Routing\Route as Router;
use Bastinald\Malzahar\Components\Livewire;
use App\Components\Blade\Layouts\AuthLayout;

class Home extends Livewire
{
    /**
     * Set our home route.
     *
     * @return \Illuminate\Routing\Route|null
     */
    public function route(): ?Router
    {
        return Route::get('/home', static::class)
            ->name('home')
            ->middleware('auth');
    }

    /**
     * Home meta title.
     *
     * @return string|null
     */
    public function title(): ?string
    {
        return __('Home');
    }

    /**
     * Return our home component template.
     *
     * @return \App\Components\Blade\Layouts\AuthLayout
     */
    public function template(): AuthLayout
    {
        return AuthLayout::make(
            Html::h1($this->title())
                ->class('text-3xl font-bold mb-4'),

            Html::p(__('You are logged in!')),
        );
    }
}
