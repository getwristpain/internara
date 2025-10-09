<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Password extends \Illuminate\Validation\Rules\Password
{
    public static function auto(int $min = 8): static
    {
        if (app()->isLocal()) {
            return static::bad($min);
        }

        return static::medium($min);
    }

    public static function bad(int $min = 8): static
    {
        return parent::min($min)
            ->letters();
    }

    public static function low(int $min = 8): static
    {
        return parent::min($min)
            ->letters()
            ->numbers();
    }

    public static function medium(int $min = 8): static
    {
        return parent::min($min)
            ->letters()
            ->numbers()
            ->symbols()
            ->uncompromised();
    }

    public static function high(int $min = 12): static
    {
        return parent::min($min)
            ->letters()
            ->numbers()
            ->symbols()
            ->mixedCase()
            ->uncompromised();
    }
}
