<?php

namespace App\Helpers;

use Illuminate\Support\Facades\RateLimiter;

class RateLimiterWrapper extends Helper
{
    protected $rateLimiter;

    protected $throttleKey;

    protected $maxAttempts;

    protected $decaySeconds;

    public function __construct(RateLimiter $rateLimiter, string $action = '', string $key = '', int $maxAttempts = 5, int $decaySeconds = 60)
    {
        $this->rateLimiter = $rateLimiter;
        $this->throttleKey = $this->throttleKey($action, $key);
        $this->maxAttempts = $maxAttempts;
        $this->decaySeconds = $decaySeconds;
    }

    public function withMessages(array $messages = []): static
    {
        if ($this->check()) {
            $seconds = $this->availableIn();

            $message = $messages['too_many_attempts'] ?? 'Too many attempts. Please try again in :seconds seconds.';
            $message = str_replace(':seconds', $seconds, $message);

            abort(429, $message);
        }

        $this->hit();

        return $this;
    }

    public function check(): bool
    {
        return $this->rateLimiter->tooManyAttempts($this->throttleKey, $this->maxAttempts);
    }

    public function hit(): void
    {
        $this->rateLimiter->hit($this->throttleKey, $this->decaySeconds);
    }

    public function reset(): void
    {
        $this->rateLimiter->clear($this->throttleKey);
    }

    public function availableIn(): int
    {
        return $this->rateLimiter->availableIn($this->throttleKey);
    }

    public function attempts(): int
    {
        return $this->rateLimiter->attempts($this->throttleKey);
    }

    public function maxAttempts(): int
    {
        return $this->maxAttempts;
    }

    public function decaySeconds(): int
    {
        return $this->decaySeconds;
    }

    public function getRateLimiter(): RateLimiter
    {
        return $this->rateLimiter;
    }

    public function getThrottleKey(): string
    {
        return $this->throttleKey;
    }

    private function throttleKey(string $action = '', string $key = ''): string
    {
        $action = $action ?: request()->route()->getName();
        $key = $key ?: request()->ip();

        return "{$action}:{$key}";
    }
}
