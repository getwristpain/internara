<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Throwable;

class Debugger extends Helper
{
    protected Throwable $exception;

    protected string $message = '';

    protected array $context = [];

    protected array $properties = [];

    protected bool $isDebug = false;

    public function __construct()
    {
        $this->isDebug = self::isDebug();
    }

    public static function debug(Throwable $exception, string $message = '', array $context = [], array $properties = []): static
    {
        $static = new static();
        $static->exception = $exception;
        $static->message = Sanitizer::sanitize($message ?? $exception->getMessage(), 'message');
        $static->context = Sanitizer::sanitize($context, 'sensitive');
        $static->properties = $static->normalizeDebugProps($properties);

        return $static;
    }

    public static function isDebug(): bool
    {
        return app()->environment(['local', 'dev', 'development', 'test', 'testing']) && (config('app.debug', false) === true);
    }

    public function storeLog(): void
    {
        $properties = $this->isDebug ? $this->properties : $this->context;

        Log::debug($this->message, $properties);
    }

    public function storeSession(): void
    {
        $properties = array_merge([
            'message' => $this->message,
        ], $this->isDebug ? $this->properties : $this->context);

        if (! session()->has('debug')) {
            session(['debug' => []]);
        }

        session()->push('debug', $properties);
    }

    public function exception(): Throwable
    {
        return $this->exception;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getContext(): array
    {
        return $this->context;
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function dump(bool $die = false): void
    {
        $properties = $this->isDebug ? $this->properties : $this->context;

        if ($die) {
            dd($this->message, $properties);
        }

        dump($this->message, $properties);
    }

    public function throw(): never
    {
        throw $this->exception;
    }

    public function throwIf(bool|callable $condition): void
    {
        if (is_bool($condition) && $condition) {
            $this->throw();
        } elseif ($condition()) {
            $this->throw();
        }
    }

    public function throwUnless(bool|callable $condition): void
    {
        $this->throwIf(! $condition);
    }

    public function abort(?int $code = null, array $header = []): never
    {
        abort($code ?? $this->exception->getCode(), $this->message, $header);
    }

    public function abortIf(bool|callable $condition, ?int $code = null, array $header = []): void
    {
        if (is_bool($condition) && $condition) {
            $this->abort($code, $header);
        } elseif ($condition()) {
            $this->abort($code, $header);
        }
    }

    public function abortUnless(bool|callable $condition, ?int $code = null, array $header = []): void
    {
        $this->abortIf(!$condition, $code, $header);
    }

    protected function normalizeDebugProps(array $properties = []): array
    {

        $formattedProps = $this->formatProperties($properties);
        $formattedException = empty($this->exception) ? [] : $this->formatException($this->exception);

        return Helper::filter(array_merge($formattedProps, [
            'context' => $this->context,
            'exception' => $formattedException,
        ]));
    }

    protected function exceptionTraceLineLimit(Throwable $exception, int $limit = 5): string
    {
        $fullTrace = $exception->getTrace();
        $limitedTrace = array_slice($fullTrace, 0, $limit);

        $traceAsString = '';
        foreach ($limitedTrace as $index => $frame) {
            $file = $frame['file'] ?? 'internal function';
            $line = $frame['line'] ?? '?';
            $function = $frame['function'] ?? 'unknown';

            $traceAsString .= "\n#{$index} [{$file}]({$line}): {$function}\n";
        }

        return $traceAsString;
    }

    protected function formatException(Throwable $exception): array
    {
        return [
            'message' => Sanitizer::sanitize($exception->getMessage(), 'message'),
            'type' => get_class($exception),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'stack' => $this->exceptionTraceLineLimit($exception),
        ];
    }

    protected function formatProperties(array $properties = []): array
    {
        $properties = array_merge([
            'timestamp' => now()->toDateTimeString(),
        ], Sanitizer::sanitize($properties, 'sensitive'));

        if ($this->isDebug()) {
            $properties = array_merge([
                'ip' => request()->ip() ?? '',
                'userAgent' => request()->userAgent() ?? '',
                'userId' => auth()->id() ?? '',
                'url' => request()->fullUrl() ?? '',
                'method' => request()->method() ?? '',
                'route' => request()->route() ? request()->route()->getName() : '',
            ], $properties);
        }

        return Helper::filter($properties);
    }
}
