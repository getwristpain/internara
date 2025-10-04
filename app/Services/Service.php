<?php

namespace App\Services;

use App\Exceptions\AppException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class Service
{
    /**
     * Generates a standardized, unique throttle key.
     *
     * @param string $actionName The name of the action being limited (e.g., 'create_jurnal').
     * @param string|int|null $identifier A unique scope identifier (e.g., User ID, IP address).
     * @return string
     */
    protected function generateThrottleKey(string $actionName, string|int|null $identifier = null): string
    {

        $uniqueId = $identifier ?? (auth()->id() ?? request()->ip());

        $key = implode(':', [
            Str::slug(class_basename(static::class), '_'),
            Str::slug($actionName, '_'),
            $uniqueId,
        ]);

        return Str::lower($key);
    }

    /**
     * Checks if a specific action or key has exceeded its rate limit.
     * Throws an AppException if the limit is exceeded.
     *
     * @param string $actionKey A unique key or action name for the rate limit (e.g., 'create_jurnal').
     * @param int $maxAttempts The maximum attempts allowed.
     * @param int $decayMinutes The time window in minutes.
     * @throws \App\Exceptions\AppException
     * @return void
     */
    public function ensureNotRateLimited(
        string $actionKey,
        int $maxAttempts = 5,
        int $decayMinutes = 1
    ): void {

        $throttleKey = $this->generateThrottleKey(
            actionName: $actionKey,
            identifier: auth()->id()
        );

        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {

            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = ceil($seconds / 60);

            $serviceName = class_basename(static::class);
            $actionDescription = Str::title(Str::replace('_', ' ', Str::snake($actionKey)));

            $userMessage = "Anda telah mencapai batas maksimal ({$maxAttempts} kali) untuk tindakan '{$actionDescription}' pada {$serviceName} dalam {$decayMinutes} menit. Silakan coba lagi dalam waktu **{$minutes} menit**.";

            $logMessage = "Rate limit exceeded for key '{$throttleKey}'. Available in {$seconds} seconds.";

            throw new AppException(
                $userMessage,
                $logMessage,
                429
            );
        }

        RateLimiter::hit($throttleKey, $decayMinutes * 60);
    }
}
