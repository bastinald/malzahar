<?php

namespace App\Components\Livewire\Auth;

use Livewire\Redirector;
use Illuminate\Support\Facades\Auth;
use App\Components\Blade\Forms\Input;
use Illuminate\Support\Facades\Route;
use App\Components\Blade\Forms\Button;
use App\Providers\RouteServiceProvider;
use Bastinald\Malzahar\Components\Html;
use Illuminate\Routing\Route as Router;
use Bastinald\Malzahar\Components\Livewire;
use App\Components\Blade\Layouts\GuestLayout;

class Login extends Livewire
{
    /**
     * Login emaill property.
     * 
     * @var string
     */
    public string $email;
    
    /**
     * Login password property.
     * 
     * @var string
     */
    public string $password;

    /**
     * Set the login route.
     *
     * @return \Illuminate\Routing\Route|null
     */
    public function route(): ?Router
    {
        return Route::get('/login', static::class)
            ->name('login')
            ->middleware('guest');
    }

    /**
     * Set the login meta title.
     *
     * @return string|null
     */
    public function title(): ?string
    {
        return __('Login');
    }

    /**
     * Return our guest layout template.
     *
     * @return \App\Components\Blade\Layouts\GuestLayout
     */
    public function template(): GuestLayout
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

    /**
     * Set the validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }

    /**
     * Log the user in and redirect.
     *
     * @return \Livewire\Redirector
     */
    public function login(): Redirector
    {
        $this->validate();

        if (!Auth::attempt($this->only(['email', 'password']), true)) {
            $this->addError('email', __('auth.failed'));

            return redirect(route('index'));
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
