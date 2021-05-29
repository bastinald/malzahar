<?php

namespace Bastinald\Malzahar\Traits;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait HasPassword
{
    /**
     * Gnerate a password if required.
     *
     * @return void
     */
    protected static function bootHasPassword(): void
    {
        static::saving(function ($model) {
            if ($model->password &&
                Str::length($model->password) < 60 &&
                !Str::startsWith($model->password, '$2y$')) {
                $model->password = Hash::make($model->password);
            }
        });
    }
}
