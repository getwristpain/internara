<?php

namespace App\Helpers;

use App\Helpers\RateLimiterWrapper;
use Illuminate\Support\Facades\RateLimiter;

class Security extends Helper
{
    public static function rateLimiter(string $action = '', string $key = '', int $maxAttempts = 5, int $decaySeconds = 60): RateLimiterWrapper
    {
        $rateLimiter = app(RateLimiter::class);

        return RateLimiterWrapper::make($rateLimiter, $action, $key, $maxAttempts, $decaySeconds);
    }
}
