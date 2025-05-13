<?php

namespace App\Helpers;

use Illuminate\Support\Facades\RateLimiter;

class Security extends Helper
{
    public static function rateLimiter(string $action = '', string $key = '', int $maxAttempts = 5, int $decaySeconds = 60): RateLimiterWrapper
    {
        $rateLimiter = app(RateLimiter::class);

        return new RateLimiterWrapper($rateLimiter, $action, $key, $maxAttempts, $decaySeconds);
    }

    public static function validate(array $data, array $rules, array $messages = [], array $attributes = []): ValidatorWrapper
    {
        try {
            return app(ValidatorWrapper::class)->validate($data, $rules, $messages, $attributes);
        } catch (\Throwable $th) {
            app(parent::class)->debug('error', 'Validation failed.', $th);
            throw $th;
        }
    }
}
