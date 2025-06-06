<?php

namespace App\Helpers;

use Illuminate\Support\Facades\RateLimiter;

class RateLimiterWrapper extends Helper
{
    protected $rateLimiter;

    protected $throttleKey;

    protected $maxAttempts;

    protected $decaySeconds;

    protected function response(): LogicResponse
    {
        return new LogicResponse();
    }

    public static function make(RateLimiter $rateLimiter, string $action = '', string $key = '', int $maxAttempts = 5, int $decaySeconds = 60): static
    {
        $instance = new static();
        $instance->rateLimiter = $rateLimiter;
        $instance->throttleKey = $instance->throttleKey($action, $key);
        $instance->maxAttempts = $maxAttempts;
        $instance->decaySeconds = $decaySeconds;

        return $instance;
    }

    public function check(): LogicResponse
    {
        if ($this->rateLimiter->tooManyAttempts($this->throttleKey, $this->maxAttempts)) {
            $seconds = $this->availableIn();

            $message = 'Too many attempts. Please try again in :seconds seconds.';
            $message = str_replace(':seconds', $seconds, $message);

            $this->response()->failure($message)
                ->withType('RateLimiter');
        }

        $this->hit();
        return $this->response()->success()->operator($this);
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
