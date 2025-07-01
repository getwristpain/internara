<?php

namespace App\Helpers;

use App\Contracts\DebuggerContract;

class Debugger extends Helper implements DebuggerContract
{
    /**
     * ------------------------------------------------------------------------
     * Exception and State Storage
     * ------------------------------------------------------------------------
     * Holds the main exception instance and additional contextual properties.
     */

    /** @var \Throwable */
    protected \Throwable $exception;

    /** @var array<string, mixed> */
    protected array $properties = [];

    /**
     * ------------------------------------------------------------------------
     * Static Factory and Utility Methods
     * ------------------------------------------------------------------------
     * Responsible for instance creation and environment-related utilities.
     */

    /**
     * Handle an exception with optional logging and throwing.
     */
    public static function handle(
        \Throwable|string $exception = '',
        array $properties = [],
        bool $throw = false,
        bool $log = true,
    ): static {
        $instance = static::from($exception)
            ->withProperties($properties);

        if ($log) {
            $instance->storeLog();
        }

        if (static::isDebug() && $throw) {
            $instance->throw();
        }

        return $instance;
    }

    /**
     * Create a debugger instance from an exception or a message string.
     */
    public static function from(\Throwable|string $exception = ''): static
    {
        $instance = new static();
        $instance->ensureIsException($exception);
        $instance->exception = empty($exception)
            ? new \Exception('An unknown error has occurred.')
            : (is_string($exception) ? new \Exception($exception) : $exception);

        return $instance;
    }

    /**
     * @param \Throwable|string $exception
     *
     * @return void
     */
    protected function ensureIsException(\Throwable|string $exception = ''): void
    {
        if (!is_string($exception) && !is_a($exception, \Exception::class)) {
            throw $exception;
        }
    }

    /**
     * Determine if the current environment is in debug mode.
     */
    public static function isDebug(): bool
    {
        return app()->environment(['local', 'dev', 'development', 'test', 'testing'])
            && config('app.debug', false) === true;
    }

    /**
     * ------------------------------------------------------------------------
     * Instance Mutators
     * ------------------------------------------------------------------------
     * Modify the internal state of the instance with contextual data.
     */

    /**
     * Attach request-related properties to the debugger instance.
     */
    public function withProperties(array $properties = []): static
    {
        $this->properties = array_merge($properties, [
            'clientIp'   => request()->getClientIp(),
            'ip'         => request()->ip(),
            'method'     => request()->method(),
            'url'        => request()->url(),
            'userAgent'  => request()->userAgent(),
            'userId'     => auth()->id(),
        ]);

        return $this;
    }

    /**
     * ------------------------------------------------------------------------
     * Instance Accessors
     * ------------------------------------------------------------------------
     * Retrieve internal data such as the exception or contextual properties.
     */

    /**
     * Get the stored exception object.
     */
    public function exception(): \Throwable
    {
        return $this->exception;
    }

    /**
     * Get all contextual properties attached to this instance.
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * Create a LogicResponse instance with this exception.
     *
     * @return LogicResponse
     */
    public function response(): LogicResponse
    {
        return parent::response()
            ->failure($this->exception()->getMessage())
            ->withType($this->exception())
            ->withCode($this->exception()->getCode());
    }

    /**
     * ------------------------------------------------------------------------
     * Core Actions (Main API)
     * ------------------------------------------------------------------------
     * Main behaviors such as logging, throwing, aborting, and dumping state.
     */

    /**
     * Store the exception into the application log.
     */
    public function storeLog(): static
    {
        $this->response()
            ->storeLog();

        return $this;
    }

    /**
     * Immediately throw the stored exception.
     *
     * @throws \Throwable
     */
    public function throw(): never
    {
        throw $this->exception();
    }

    /**
     * Abort the request with the exception’s message and code.
     */
    public function abort(?int $code = null, array $headers = []): never
    {
        abort(
            $code ?? ($this->exception()->getCode() ?: 500),
            $this->exception()->getMessage(),
            $headers
        );
    }

    /**
     * Dump the debugger data as array, optionally halting execution.
     */
    public function dump(bool $die = false): void
    {
        $die ? dd($this->toArray()) : dump($this->toArray());
    }

    /**
     * ------------------------------------------------------------------------
     * Helper Methods (Internal Use Only)
     * ------------------------------------------------------------------------
     * Conditional logic methods for expressive error handling.
     */

    /**
     * Throw the exception if the given condition is true.
     */
    public function throwIf(bool $condition): static
    {
        if ($condition) {
            $this->throw();
        }

        return $this;
    }

    /**
     * Throw the exception unless the given condition is true.
     */
    public function throwIfNot(bool $condition): static
    {
        return $this->throwIf(!$condition);
    }

    /**
     * Abort the request if the condition is true.
     */
    public function abortIf(bool $condition, ?int $code = null, array $headers = []): static
    {
        if ($condition) {
            $this->abort($code, $headers);
        }

        return $this;
    }

    /**
     * Abort the request unless the condition is true.
     */
    public function abortIfNot(bool $condition, ?int $code = null, array $headers = []): static
    {
        return $this->abortIf(!$condition, $code, $headers);
    }

    /**
     * Format a limited portion of the exception's stack trace.
     */
    protected function formattedTrace(int $limit = 5): array
    {
        $trace = array_slice($this->exception()->getTrace(), 0, $limit);

        return array_map(
            fn ($item, $index) =>
                sprintf(
                    '#%d %s(%s): %s%s%s',
                    $index,
                    $item['file'] ?? '[internal function]',
                    $item['line'] ?? '-',
                    $item['class'] ?? '',
                    $item['type'] ?? '',
                    $item['function'] ?? ''
                ),
            $trace,
            array_keys($trace)
        );
    }

    /**
     * ------------------------------------------------------------------------
     * Serialization Methods
     * ------------------------------------------------------------------------
     * Converts internal debugger state into array format for logging/debugging.
     */

    /**
     * Convert the exception and its context into an array.
     */
    public function toArray(): array
    {
        return [
            'message'    => $this->exception()->getMessage(),
            'code'       => $this->exception()->getCode(),
            'file'       => $this->exception()->getFile(),
            'line'       => $this->exception()->getLine(),
            'stack'      => $this->formattedTrace(),
            'properties' => $this->getProperties(),
        ];
    }
}
