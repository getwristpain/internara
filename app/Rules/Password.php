<?php

namespace App\Rules;

use Closure;
use Illuminate\Validation\Rules\Password as PasswordRules;

class Password extends PasswordRules
{
    public static function default(int $min = 8): static
    {
        return static::bad($min);
    }

    /**
     * Only use in development, do not use in production
     */
    public static function bad(int $min = 8): static
    {
        if (!setting()->isDev()) {
            return static::medium($min);
        }

        return static::min($min);
    }

    public static function low(int $min = 8): static
    {
        return static::min($min)
            ->letters()
            ->numbers();
    }

    public static function medium(int $min = 8): static
    {
        return static::min($min)
            ->letters()
            ->numbers()
            ->uncompromised();
    }

    public static function strong(int $min = 10): static
    {
        return static::min($min)
            ->letters()
            ->numbers()
            ->symbols()
            ->mixedCase()
            ->uncompromised();
    }
}
