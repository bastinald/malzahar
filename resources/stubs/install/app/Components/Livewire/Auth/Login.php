<?php

namespace App\Components\Livewire\Auth;

use App\Components\Blade\Forms\Button;
use App\Components\Blade\Forms\Input;
use App\Components\Blade\Layouts\GuestLayout;
use App\Providers\RouteServiceProvider;
use Bastinald\Malzahar\Components\Html;
use Bastinald\Malzahar\Components\Livewire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Login extends Livewire
{
    public $email, $password;

    public function route()
    {
        return Route::get('/login', static::class)
            ->name('login')
            ->middleware('guest');
    }

    public function title()
    {
        return __('Login');
    }

    public function template()
    {
        return GuestLayout::make(
            Html::form(
                Input::make()
                    ->type('email')
                    ->placeholder(__('Email'))
                    ->error($this->error('email'))
                    ->wireModelDefer('email'),

                Input::make()
                    ->type('password')
                    ->placeholder(__('Password'))
                    ->error($this->error('password'))
                    ->wireModelDefer('password'),

                Button::make(__('Login'))
                    ->type('submit')
                    ->class('w-full'),
            )->wireSubmitPrevent('login'),
        );
    }

    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }

    public function login()
    {
        $this->validate();

        if (!Auth::attempt($this->only(['email', 'password']), true)) {
            $this->addError('email', __('auth.failed'));

            return;
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
