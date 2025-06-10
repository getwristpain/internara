<?php

namespace App\Helpers;

use Throwable;
use App\Helpers\Helper;
use App\Helpers\Sanitizer;
use App\Helpers\LogicResponse;
use Illuminate\Support\Facades\Log;

class Debugger extends Helper
{
    protected ?LogicResponse $response = null;

    protected Throwable $exception;

    protected string $message = '';

    protected array $context = [];

    protected array $properties = [];

    protected bool $isDebug = false;

    public function __construct()
    {
        $this->isDebug = self::isDebug();
    }

    public static function debug(Throwable $exception, string $message = '', array $context = [], array $properties = [], bool $throw = false): static
    {
        $instance = new static();
        $instance->exception = $exception;
        $instance->message = Sanitizer::sanitize(!empty($message) ? $message : $exception->getMessage(), 'message');
        $instance->context = Sanitizer::sanitize($context, 'sensitive');
        $instance->properties = $instance->normalizeDebugProps($properties);

        $instance->response = $instance->response()->failure($exception->getMessage())
            ->withType('Debugger')
            ->storeLog('debug');

        if ($instance->isDebug() && $throw) {
            $instance->throw();
        }

        return $instance;
    }

    public static function isDebug(): bool
    {
        return app()->environment(['local', 'dev', 'development', 'test', 'testing']) && (config('app.debug', false) === true);
    }

    public function response(): LogicResponse
    {
        return $this->response ?? new LogicResponse();
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

    public function throw(): void
    {
        throw $this->exception ?? null;
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

    public function toArray(): array
    {
        return array_merge(['message' => $this->message], $this->properties);
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
            'requests' => [
                    'ip' => request()->ip() ?? '',
                    'method' => request()->method() ?? '',
                    'route' => request()->route() ? request()->route()->getName() : '',
                    'url' => request()->fullUrl() ?? '',
                    'userAgent' => request()->userAgent() ?? '',
                    'userId' => auth()->id() ?? '',
                ],
            'timestamp' => now()->toDateTimeString(),
        ], Sanitizer::sanitize($properties, 'sensitive'));

        return Helper::filter($properties);
    }
}
