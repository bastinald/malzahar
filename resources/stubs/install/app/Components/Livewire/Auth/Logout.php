<?php

namespace App\Components\Livewire\Auth;

use Livewire\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Route as Router;
use Bastinald\Malzahar\Components\Livewire;

class Logout extends Livewire
{
    /**
     * Set the logout route.
     *
     * @return \Illuminate\Routing\Route|null
     */
    public function route(): ?Router
    {
        return Route::get('/logout', static::class)
            ->name('logout')
            ->middleware('auth');
    }

    /**
     * Logout the user and redirect.
     *
     * @return \Livewire\Redirector
     */
    public function mount(): Redirector
    {
        Auth::logout();

        return redirect()->to('/');
    }
}
