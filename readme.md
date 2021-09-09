# No Longer Maintained

I have stopped using Tailwind and am no longer supporting this package. If you like it, make your own fork.

---

# Malzahar

A magic PHP framework. Build reactive web apps without writing HTML, CSS, or JavaScript! Powered by Tailwind, Alpine, Laravel, & Livewire.

<a href="https://www.youtube.com/watch?v=mXDC7T_YBdU"><img src="https://i.postimg.cc/gk6xdRpN/Screen-Shot-2021-05-27-at-3-55-55-AM.png"></a>

### Requirements

-   PHP 8
-   Laravel 8
-   NPM

## Installation

Create a new Laravel app:

```console
laravel new my-app
```

Configure `.env` APP, DB, & MAIL values:

```env
APP_*
DB_*
MAIL_*
```

Require Malzahar via composer:

```console
composer require bastinald/malzahar
```

Run the install command:

```console
php artisan malz:install
```

This will install & configure Tailwind & Alpine and create some example components to get you started.

## Commands

### Automatic Migrations

```console
php artisan malz:migrate {--f} {--s} {--fs}
```

This will run the automatic migrations by comparing the `migration` methods of your models to the current database table structures and apply any necessary changes. Use the `--f` option for fresh, `--s` for seed, or `--fs` for both. Using
automatic migrations is completely optional with Malzahar.

### Making Blade Components

```console
php artisan malz:blade {class}
```

This will generate a Blade abstraction component inside the `app/Components/Blade` folder. As with all generator commands, you may specify a sub folder using slashes or dot notation for the `class`.

### Making Livewire Components

```console
php artisan malz:livewire {class} {--f}
```

This will generate a reactive Livewire component inside the `app/Components/Livewire` folder. Use the `--f` option to make a full-page component with automatic routing included.

### Making Models

```console
php artisan malz:model {class}
```

This will generate an Eloquent model including a `migration` and `definition` method for use with the automatic migration command. It also creates a factory for the model.

## Components

### Blade Components

Blade components are used to abstract one or more HTML components into their own PHP class so that they can be reused and maintained with ease.

For example, let's say you need to make a reusable `Button` component for your forms:

```php
namespace App\Components\Blade\Forms;

use Bastinald\Malzahar\Components\Blade;
use Bastinald\Malzahar\Components\Html;

class Button extends Blade
{
    public $color = 'blue';

    public function attributes()
    {
        return [
            'type' => 'button',
        ];
    }

    public function classes()
    {
        return [
            'text-white rounded-md shadow-sm px-4 py-2',
            'bg-' . $color . '-600 hover:bg-' . $color . '-700',
        ];
    }

    public function template()
    {
        return Html::button($this->slot)
            ->merge($this);
    }
}
```

The design behind these components works similar to standard Laravel blade components, except we have a few more features. Notice the `attributes` and `classes` methods. This is where you would specify default attributes and classes for the
component. These are applied via the `merge($this)` method on the `Html::button()` component. You can also see custom properties being utilized e.g. `$color` in the example above. Properties are different from attributes. Also, notice the use of `$this->slot` in the component template. The slot is what is passed via the `make()` method parameters.

Now you can use this `Button` component inside any other component via the `make()` method:

```php
class Login extends Livewire
{
    public $email;

    public function template()
    {
        return GuestLayout::make(
            Html::form(
                Input::make()
                    ->type('email')
                    ->placeholder(__('Email'))
                    ->error($this->error('email'))
                    ->wireModelDefer('email'),

                Button::make(__('Login'))
                    ->color('red')
                    ->type('submit')
                    ->class('w-full'),
            )->wireSubmitPrevent('login'),
        );
    }
```

Notice how we can still pass a `color`, `type` and `class` to the `Button` component via chained methods, which will be merged with whatever default properties, attributes and classes are specified inside the component class itself.

Chain methods on the component in order to set class properties, HTML attributes, and CSS classes via Tailwind. Just use the name of the property or attribute as the method name, and its parameter will be the value. Tailwind classes can be applied via the `class` method.

### Livewire Components

Livewire components are reactive components used for making interactive partial and full page experiences.

Full page components should use a `route` and `title` method e.g.:

```php
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
```

This full page component would be accessible via the `/home` route.

For partial components, you can create any components you want to include inside of other Livewire components, and then include them via the `make()` method. You use the `make()` method to construct all of your custom Blade and Livewire components.

Let's say we created this simple partial component:

```php
class Alert extends Livewire
{
    public $message;

    public function mount($message)
    {
        $this->message = $message;
    }

    public function template()
    {
        return Html::div(
            Html::p(__($this->message))
                ->class('font-bold mb-4'),

            Html::button(__('Change Message'))
                ->class('bg-blue-600 text-white px-4 py-2')
                ->wireClick('changeMessage'),
        );
    }

    public function changeMessage()
    {
        $this->message = 'I am a changed message.';
    }
}
```

Now we can include, and even declare mounted properties for this `Alert` component in our other Livewire components via `make()`:

```php
class Home extends Livewire
{
    public function template()
    {
        return AuthLayout::make(
            Html::h1($this->title())
                ->class('text-3xl font-bold mb-4'),

            Alert::make()->message('Hello, world!'),
        );
    }
```

Notice how we can pass a `message` property to the `mount()` method via a magic `message()` method that is available to us dynamically. Malzahar works similarly for Blade, Livewire, and HTML components. You're a wizard, Harry!

Oh, and if you need to grab validation errors, you can use the `$this->error()` method inside your Livewire component:

```php
use App\Components\Blade\Forms\Button;
use App\Components\Blade\Forms\Input;
use App\Components\Blade\Layouts\GuestLayout;
use Bastinald\Malzahar\Components\Html;
use Bastinald\Malzahar\Components\Livewire;

class Login extends Livewire
{
    public $email, $password;

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
        ];
    }

    public function login()
    {
        $this->validate();

        // attempt to log the user in
    }
```

### HTML Components

HTML components are the building blocks for all of your other components. The syntax is similar to other Malzahar components, and we can add any attributes we want via magically chained methods.

All HTML components can be made by using their tag as the constructor method, and attributes for said tag come after:

```php
public $email;

public function template()
{
    return Html::div(
        Html::h1(__('Hello, world')),

        Html::input()
            ->type('email')
            ->placeholder(__('Email'))
            ->wireModelDefer('email'),

        Html::p(__('Look ma, no hands!'))
            ->class('text-blue-600 font-bold'),
    );
}
```

If you notice, you'll see that the parameters for the constructing method contain the slot (or content) for that HTML element. See how the `div` in the example above contains an `h1`, `input`, and `p` inside of it. Same goes for the `h1` element, it has some translated text inside it.

For chained attribute methods, just specify an HTML element attribute name, and it's value as the parameter. Look at the `Html::input()` example above, we have given it a `type` of `email`, etc.

HTML components also support Livewire and Alpine methods as well. In the example above, you can see the use of `wireModelDefer('email')`, which actually translates to `wire:model.defer="email"` in the rendered HTML. This is used to bind the input value to the `$email` property when an action is performed (`defer`).

Same concept goes for Alpine. Let's say we wanted to add some Tailwind transitions to a dropdown:

```php
Html::div(
    Html::button('Open Dropdown')
        ->xOnClick('open = true'),

    Html::div('Dropdown Body')
        ->xShow('open')
        ->xTransitionEnter('transition ease-out duration-100')
        ->xTransitionEnterStart('transform opacity-0 scale-95')
        ->xTransitionEnterEnd('transform opacity-100 scale-100')
        ->xTransitionLeave('transition ease-in duration-75')
        ->xTransitionLeaveStart('transform opacity-100 scale-100')
        ->xTransitionLeaveEnd('transform opacity-0 scale-95')
        ->xOnClickAway('open = false')
        ->class('absolute bg-white p-3')
)->xData('{ open: false }'),
```

Notice how Livewire attributes start with `wire`, and the Alpine attributes start with `x`. Malzahar is smart enough to format these attributes to their proper syntax when being rendered to actual HTML on compile.

### Dynamic Components

Sometimes you will need to use third party blade components in your Malzahar app. Fortunately, this package makes this very simple via the `Dynamic` class.

For example, let's say I installed the Laravel Honey package. Normally, to include this component inside one of my views, I would use something like this:

```html
<x-honey recaptcha />
```

Now we can't use actual HTML with Malzahar, so what do we do? We use the `Dynamic` class with a magic constructor method:

```php
Dynamic::honey(),
```

Passing attributes to the dynamic component is as simple as adding a chained method:

```php
Dynamic::honey()->recaptcha(),
```

It all works similarly to other Malzahar components. With dynamic components, the constructor method is the name of the component itself, and attributes are passed the same way you would with HTML or other components.

Check out the `NavLink` example that was created when you installed Malzahar. You can even see Dynamic components utilizing the `merge($this)` method inside a custom Blade component:

```php
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
```

## Statements

### If Statement

Conditional `if` statements with Malzahar are easy:

```php
Statement::if($this->label,
    fn() => Html::label($this->label),
),
```

You can also use `elseif` and `else` as chained methods for your `if` statement:

```php
public $color = 'blue';

public function template()
{
    return Statement::if($this->color == 'red',
        fn() => Html::h1(__('The color is red!'))
            ->class('text-red-600'),
    )->elseif($this->color == 'blue',
        fn() => Html::h2(__('The color is blue!'))
            ->class('text-blue-600'),
    )->else(
        fn() => Html::h3(__('The color is something else!')),
    );
}
```

Notice how the first parameter of `if` is the condition, and every closure after is what will be rendered if the statement passes.

### Each Statement

`Each` statements, or loops as they're often called, allow you to iterate through a result set and display things per iteration.

For example, let's say we want to spit out a list of our users names:

```php
Statement::each(User::all(),
    fn(User $user) => Html::div(e($user->name)),
)->empty(
    fn() => Html::p('No users found.'),
),
```

The first parameter of the `each` statement is the collection or array. The second parameter is a callable function with the item, and optionally the key. You can use the `empty` method to show something if no results are found.

Also, notice how the `e` function is used here to escape the users name. Normally, you'd use the `{{ $user->name }}` syntax in a view file, which literally just calls the `e` function when compiled.

Need to use the keys of the items? No problem:

```php
Statement::each(['red' => '#ff0000', 'green' => '#00ff00'],
    fn($hexCode, $colorName) => Html::dl(
        Html::dt($colorName),
        Html::dd($hexCode),
    )->class('mb-4'),
),
```

If you have questions or need help, please use the Github issues and I will respond ASAP. Thank you for checking out this package and happy coding!
