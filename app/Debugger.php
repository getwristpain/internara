<?php

namespace App;

use App\Helpers\Helper;
use App\Helpers\Sanitizer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Spatie\Activitylog\Facades\Activity;
use Throwable;

trait Debugger
{
    protected MessageBag $errors;

    private array $allowedLevels = ['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'];

    private array $errorLevels = ['error', 'critical', 'alert', 'emergency'];

    public function getErrors(): MessageBag
    {
        return $this->errors ?? new MessageBag;
    }

    public function addError(string|array|Throwable $exception, string $level = 'error'): void
    {
        if (is_null($this->sanitizeErrorLevel($level))) {
            return;
        }
        if (! isset($this->errors)) {
            $this->errors = new MessageBag;
        }

        $this->errors->merge($this->formatException($level, $exception));
    }

    public function debug(string $level, string $message, string|array|Throwable $context = []): string
    {
        if (is_null($this->sanitizeLevel($level))) {
            return 'The level given is invalid.';
        }

        Log::log($level, $message, $this->formatContext($level, $context));
        $this->addError($message, $level);

        return $message;
    }

    private function sanitizeLevel(string $level): ?string
    {
        return Sanitizer::sanitize(Str::lower($level), 'acceptabled', $this->allowedLevels);
    }

    private function sanitizeErrorLevel(string $level): ?string
    {
        return Sanitizer::sanitize(Str::lower($level), 'acceptabled', $this->errorLevels);
    }

    private function formatContext(string $level, string|array|Throwable $context = []): array
    {
        return match (true) {
            is_array($context) => $context,
            is_string($context) => ['context' => $context],
            $context instanceof Throwable => $this->formatException($level, $context),
            default => []
        };
    }

    private function formatException(string $level, string|array|Throwable $exception = []): array
    {
        if (is_null($this->sanitizeErrorLevel($level))) {
            return [];
        }

        return match (true) {
            $exception instanceof Throwable => [
                $level => [[
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'line' => $exception->getLine(),
                    'file' => $exception->getFile(),
                    'trace' => $exception->getTraceAsString(),
                    'timestamp' => now()->toDateTimeString(),
                ]],
            ],
            is_string($exception) => [
                $level => [[
                    'message' => Helper::stringify($exception),
                    'timestamp' => now()->toDateTimeString(),
                ]],
            ],
            default => (array) $exception
        };
    }

    public function log(string|array $messages, array $context = [], Model|string|int|null $causedBy = null)
    {
        if (is_array($messages)) {
            foreach ($messages as $message) {
                $this->storeLog($message['message'], $message['context'] ?? $context, $message['causedBy'] ?? $causedBy);
            }
        } else {
            $this->storeLog((string) $messages, $context, $causedBy);
        }
    }

    protected function storeLog(string $message, array $context = [], Model|string|int|null $causedBy = null)
    {
        $causedBy ??= auth()->user() ?? null;

        Log::info($message, [
            'context' => $context,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'user_id' => auth()->id() ?? '',
            'datetime' => now()->toDateTimeString(),
        ]);

        Activity::causedBy($causedBy)->withProperties([
            'context' => $context,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'user_id' => auth()->id() ?? '',
            'datetime' => now()->toDateTimeString(),
        ])->log($message);
    }
}
