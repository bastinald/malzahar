<?php

namespace App\Components\Livewire;

use App\Components\Blade\Layouts\AuthLayout;
use Bastinald\Malzahar\Components\Html;
use Bastinald\Malzahar\Components\Livewire;
use Illuminate\Support\Facades\Route;

class Home extends Livewire
{
    public function route()
    {
        return Route::get('/home', static::class)
            ->name('home')
            ->middleware('auth');
    }

    public function title()
    {
        return __('Home');
    }

    public function template()
    {
        return AuthLayout::make(
            Html::h1($this->title())
                ->class('text-3xl font-bold mb-4'),

            Html::p(__('You are logged in!')),
        );
    }
}
