<?php

namespace App\Services;

use App\Helpers\LogicResponse;
use Illuminate\Support\Facades\RateLimiter;

class BaseService
{
    /**
     * Creates a configured LogicResponse instance.
     *
     * @param bool $success
     * @param string $message
     * @param array $payload
     * @return LogicResponse
     */
    protected function respond(bool $success, string $message = '', array $payload = []): LogicResponse
    {
        return LogicResponse::make($success, $message, payload: $payload)
            ->withType($this);
    }

    /**
     * Checks if the user has exceeded the attempt limit.
     *
     * @param string $key
     * @param int $maxAttempts
     * @return LogicResponse
     */
    protected function ensureNotRateLimited(string $key, int $maxAttempts = 5): LogicResponse
    {
        $throttleKey = $this->generateThrottleKey($key);

        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $message = str("Terlalu banyak percobaan. Mohon tunggu selama :seconds detik.")
                ->replace(':seconds', $seconds)->toString();

            return $this->respond(false, $message);
        }

        RateLimiter::hit($throttleKey);
        return $this->respond(true);
    }

    /**
     * Generates a unique key for the rate limiter based on the user or IP.
     *
     * @param string $key
     * @return string
     */
    private function generateThrottleKey(string $key): string
    {
        return strtolower(trim($key)) . ':' . (auth()->id() ?? request()->getClientIp());
    }
}
