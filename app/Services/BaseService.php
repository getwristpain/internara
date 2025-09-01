<?php

namespace App\Services;

use App\Helpers\Transform;
use App\Helpers\LogicResponse;
use RateLimiter;

class BaseService
{
    public function response(string $type = '', string $message = ''): LogicResponse
    {
        if (!empty($type)) {
            $type = in_array($type, ['success', 'error']) ? $type : null;
            return LogicResponse::make($type && $type === 'success', $message)
                ->withType($this)
                ->withPayload($this->toArray());
        }

        return LogicResponse::make()
            ->withType($this)
            ->withPayload($this->toArray());
    }

    public function toArray(): array
    {
        return [];
    }

    public function ensureNotRateLimited(string $key, int $maxAttempts = 5): LogicResponse
    {
        $key = $this->generateTrottleKey($key);

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            $message = Transform::from("Terlalu banyak melakukan percobaan. Tunggu hingga :seconds detik.")
                ->replace(':seconds', $seconds)
                ->toString();

            return $this->response()->error($message);
        }

        RateLimiter::increment($key);
        return $this->response()->success();
    }

    protected function generateTrottleKey(string $key): string
    {
        return strtolower(trim($key)) . ':' . (auth()->id() ?? request()->getClientIp());
    }
}
