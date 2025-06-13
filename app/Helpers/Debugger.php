<?php

namespace App\Helpers;

use App\Contracts\DebuggerContract;
use App\Helpers\Helper;
use App\Helpers\Sanitizer;
use App\Helpers\LogicResponse;

/**
 * Debugger helper for handling exceptions, logging, and debug responses.
 */
class Debugger extends Helper implements DebuggerContract
{
    /**
     * Logic response instance.
     *
     * @var LogicResponse|null
     */
    protected ?LogicResponse $response = null;

    /**
     * Exception instance.
     *
     * @var \Throwable
     */
    protected \Throwable $exception;

    /**
     * Debug message.
     *
     * @var string
     */
    protected string $message = '';

    /**
     * Debug context.
     *
     * @var array
     */
    protected array $context = [];

    /**
     * Debug properties.
     *
     * @var array
     */
    protected array $properties = [];

    /**
     * Debug mode flag.
     *
     * @var bool
     */
    protected bool $isDebug = false;

    /**
     * Debugger constructor.
     */
    public function __construct()
    {
        $this->isDebug = self::isDebug();
    }

    /**
     * Create a debug instance and log the exception.
     *
     * @param \Throwable $exception
     * @param string $message
     * @param array $context
     * @param array $properties
     * @param bool $throw
     * @return static
     */
    public static function debug(
        \Throwable $exception,
        string $message = '',
        array $context = [],
        array $properties = [],
        bool $throw = false
    ): static {
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

    /**
     * Check if the application is in debug mode.
     *
     * @return bool
     */
    public static function isDebug(): bool
    {
        return app()->environment(['local', 'dev', 'development', 'test', 'testing']) && (config('app.debug', false) === true);
    }

    /**
     * Get the logic response instance.
     *
     * @return LogicResponse
     */
    public function response(): LogicResponse
    {
        return $this->response ?? new LogicResponse();
    }

    /**
     * Get the exception instance.
     *
     * @return \Throwable
     */
    public function exception(): \Throwable
    {
        return $this->exception;
    }

    /**
     * Get the debug message.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Get the debug context.
     *
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * Get the debug properties.
     *
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * Dump debug information.
     *
     * @param bool $die
     * @return void
     */
    public function dump(bool $die = false): void
    {
        $properties = $this->isDebug ? $this->properties : $this->context;

        if ($die) {
            dd($this->message, $properties);
        }

        dump($this->message, $properties);
    }

    /**
     * Throw the exception.
     *
     * @return void
     * @throws \Throwable
     */
    public function throw(): void
    {
        throw $this->exception ?? new \Exception($this->message);
    }

    /**
     * Throw the exception if the condition is true.
     *
     * @param bool|callable $condition
     * @return void
     * @throws \Throwable
     */
    public function throwIf(bool|callable $condition): void
    {
        if ((is_bool($condition) && $condition) || (is_callable($condition) && $condition())) {
            $this->throw();
        }
    }

    /**
     * Throw the exception unless the condition is true.
     *
     * @param bool|callable $condition
     * @return void
     * @throws \Throwable
     */
    public function throwUnless(bool|callable $condition): void
    {
        $this->throwIf(!(is_callable($condition) ? $condition() : $condition));
    }

    /**
     * Abort the request with an error code and message.
     *
     * @param int|null $code
     * @param array $header
     * @return never
     */
    public function abort(?int $code = null, array $header = []): never
    {
        abort($code ?? $this->exception->getCode(), $this->message, $header);
    }

    /**
     * Abort if the condition is true.
     *
     * @param bool|callable $condition
     * @param int|null $code
     * @param array $header
     * @return void
     */
    public function abortIf(bool|callable $condition, ?int $code = null, array $header = []): void
    {
        if ((is_bool($condition) && $condition) || (is_callable($condition) && $condition())) {
            $this->abort($code, $header);
        }
    }

    /**
     * Abort unless the condition is true.
     *
     * @param bool|callable $condition
     * @param int|null $code
     * @param array $header
     * @return void
     */
    public function abortUnless(bool|callable $condition, ?int $code = null, array $header = []): void
    {
        $this->abortIf(!(is_callable($condition) ? $condition() : $condition), $code, $header);
    }

    /**
     * Get debug data as array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_merge(['message' => $this->message], $this->properties);
    }

    /**
     * Normalize debug properties.
     *
     * @param array $properties
     * @return array
     */
    protected function normalizeDebugProps(array $properties = []): array
    {
        $formattedProps = $this->formatProperties($properties);
        $formattedException = empty($this->exception) ? [] : $this->formatException($this->exception);

        return Helper::filter(array_merge($formattedProps, [
            'context' => $this->context,
            'exception' => $formattedException,
        ]));
    }

    /**
     * Limit the exception trace lines.
     *
     * @param \Throwable $exception
     * @param int $limit
     * @return string
     */
    protected function exceptionTraceLineLimit(\Throwable $exception, int $limit = 6): string
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

    /**
     * Format exception details as array.
     *
     * @param \Throwable $exception
     * @return array
     */
    protected function formatException(\Throwable $exception): array
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

    /**
     * Format debug properties.
     *
     * @param array $properties
     * @return array
     */
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
