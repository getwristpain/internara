<?php

namespace App;

use Throwable;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Log;

trait Debugger
{
    protected MessageBag $errors;
    private array $allowedLevels = ['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'];
    private array $errorLevels = ['error', 'critical', 'alert', 'emergency'];

    /**
     * Get the list of errors.
     */
    public function getErrors(): MessageBag
    {
        return $this->errors ?? new MessageBag();
    }

    /**
     * Add an error message.
     */
    public function addError(string|array|Throwable $exception, string $level = 'error'): void
    {
        $sanitizedErrorLevel = $this->sanitizeErrorLevel($level);

        if (!isset($sanitizedErrorLevel)) {
            return;
        }

        if (!isset($this->errors)) {
            $this->errors = new MessageBag();
        }

        $this->errors->merge($this->formatException($exception, $sanitizedErrorLevel));
    }

    /**
     * Log debug information and handle errors if necessary.
     */
    public function debug(string $level, string $message, string|int|array|object|null $context = null): mixed
    {
        $sanitizedLevel = $this->sanitizeLevel($level);

        Log::log($sanitizedLevel, $message, $this->formatContext($context, $sanitizedLevel));
        $this->addError($message, $sanitizedLevel);

        return $context ?? $message;
    }

    /**
     * Sanitize debugger levels.
     */
    private function sanitizeLevel(string $level): string
    {
        return Helper::sanitize(Str::lower($level), $this->allowedLevels);
    }

    /**
     * Sanitize debugger error levels.
     */
    private function sanitizeErrorLevel(string $level)
    {
        return Helper::sanitize(Str::lower($level), $this->errorLevels);
    }

    /**
     * Format debugger context to array.
     */
    private function formatContext(mixed $context = [], string $level): array
    {
        return match (true) {
            is_object($context) => Helper::objectToArray($context),
            is_array($context) => $context,
            is_string($context) => ['context' => $context],
            default => $this->formatException($context ?? [], $level)
        };
    }

    /**
     * Format the log context from an exception.
     */
    private function formatException(string|array|Throwable $exception, string $level = 'error'): array
    {
        $sanitizedLevel = $this->sanitizeErrorLevel($level);

        return match (true) {
            $exception instanceof Throwable => [
                $sanitizedLevel => [[
                    'message'   => $exception->getMessage(),
                    'code'      => $exception->getCode(),
                    'line'      => $exception->getLine(),
                    'file'      => $exception->getFile(),
                    'trace'     => $exception->getTraceAsString(),
                    'timestamp' => now()->toDateTimeString(),
                ]]
            ],
            is_string($exception) => [
                $sanitizedLevel => [[
                    'message'   => Helper::stringify($exception),
                    'timestamp' => now()->toDateTimeString(),
                ]]
            ],
            default => (array) $exception
        };
    }
}
