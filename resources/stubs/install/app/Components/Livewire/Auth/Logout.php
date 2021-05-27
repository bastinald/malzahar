<?php

namespace App\Components\Livewire\Auth;

use Bastinald\Malzahar\Components\Livewire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Logout extends Livewire
{
    public function route()
    {
        return Route::get('/logout', static::class)
            ->name('logout')
            ->middleware('auth');
    }

    public function mount()
    {
        Auth::logout();

        return redirect()->to('/');
    }
}
