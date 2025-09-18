<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;
use InvalidArgumentException;
use Throwable;

class LogicResponse
{
    /**
     * @var bool Indicates whether the response has been initialized.
     */
    private bool $initialized = false;

    /**
     * @var bool|null The success status of the response.
     */
    private ?bool $success = null;

    /**
     * @var string The main message of the response.
     */
    private string $message = '';

    /**
     * @var string The type of response, often the class name.
     */
    private string $type = 'Response';

    /**
     * @var string The human-readable status of the response.
     */
    private string $status = '';

    /**
     * @var string|int The machine-readable code of the response.
     */
    private string|int $code = '';

    /**
     * @var array The data payload of the response.
     */
    private array $payload = [];

    /**
     * @var MessageBag|null A bag of errors.
     */
    private ?MessageBag $errors = null;

    /**
     * @var bool A flag to stop further method chaining.
     */
    private bool $abort = false;

    /**
     * The constructor is private to enforce using the static factory.
     */
    private function __construct()
    {
    }

    /**
     * Creates a new instance of LogicResponse.
     *
     * @param bool $success The success status.
     * @param string $message The primary response message.
     * @param string $type The response type.
     * @param string $status The human-readable status.
     * @param string|int $code The machine-readable code.
     * @param array $payload The data payload.
     * @return self
     */
    public static function make(
        bool $success = true,
        string $message = '',
        string $type = 'Response',
        string $status = '',
        string|int $code = '',
        array $payload = []
    ): self {
        $instance = new self();
        $instance->initialize($success);

        $instance->message = $message;
        $instance->type = $type;
        $instance->status = $status ?: ($success ? 'success' : 'error');
        $instance->code = $code ?: ($success ? 'SUCCESS' : 'ERROR');
        $instance->payload = $payload;
        $instance->errors = !$success && !empty($message) ? new MessageBag(['general' => $message]) : null;

        return $instance;
    }

    /**
     * Creates a success or error response based on a condition.
     *
     * @param bool|callable $condition The condition to evaluate.
     * @param string $successMessage The message for a successful response.
     * @param string $errorMessage The message for an error response.
     * @return self
     */
    public static function decide(bool|callable $condition, string $successMessage = '', string $errorMessage = ''): self
    {
        $conditionResult = is_callable($condition) ? $condition() : (bool) $condition;

        return $conditionResult
            ? self::success($successMessage)
            : self::error($errorMessage);
    }

    /**
     * Creates a successful response.
     *
     * @param string $message
     * @return self
     */
    public static function success(string $message = ''): self
    {
        return self::make(true, $message);
    }

    /**
     * Creates an error response.
     *
     * @param string $message
     * @return self
     */
    public static function error(string $message = ''): self
    {
        return self::make(false, $message);
    }

    /**
     * Fails the response when a given condition is met.
     *
     * @param LogicResponse|callable|bool $condition
     * @param string $message The message for the new error response.
     * @return self
     * @throws InvalidArgumentException
     */
    public function failWhen(LogicResponse|callable|bool $condition, string $message = ''): self
    {
        if ($this->abort) {
            return $this;
        }

        if ($condition instanceof self) {
            return $condition->fails()
                ? $condition->withMessage($message)
                : $this;
        }

        if (is_callable($condition)) {
            $result = $condition($this);

            if ($result instanceof self) {
                return $result->fails() ? $result : $this;
            }

            if (is_bool($result)) {
                return $result ? self::error($message) : $this;
            }

            throw new InvalidArgumentException(
                sprintf('The $condition must return LogicResponse or a boolean. %s given.', gettype($result))
            );
        }

        return $condition ? self::error($message) : $this;
    }

    /**
     * Executes a callback if the response is successful.
     *
     * @param callable(LogicResponse): mixed $callback The callback to execute.
     * @return LogicResponse|mixed The return value of the callback or the current object.
     */
    public function then(callable $callback): mixed
    {
        if ($this->abort) {
            return $this;
        }

        if ($this->passes()) {
            return $callback($this);
        }

        return $this;
    }

    /**
     * Executes a callback if the response has failed.
     *
     * @param callable(LogicResponse): mixed $callback The callback to execute.
     * @return LogicResponse|mixed The return value of the callback or the current object.
     */
    public function otherwise(callable $callback): mixed
    {
        if ($this->fails()) {
            return $callback($this);
        }

        return $this;
    }

    /**
     * Adds attributes to the response.
     *
     * @param string|array $attributes The attribute name or an associative array.
     * @param mixed $value The value of the attribute.
     * @return self
     * @throws InvalidArgumentException
     */
    public function with(string|array $attributes, mixed $value = null): self
    {
        if (is_array($attributes)) {
            foreach ($attributes as $attr => $val) {
                $this->with($attr, $val);
            }
            return $this;
        }

        // We'll use a match expression for a cleaner approach.
        return match ($attributes) {
            'message' => $this->withMessage($value),
            'type'    => $this->withType($value),
            'status'  => $this->withStatus($value),
            'code'    => $this->withCode($value),
            'payload' => $this->withPayload($value),
            'errors'  => $this->withErrors($value),
            default   => throw new InvalidArgumentException("Attribute '{$attributes}' not found"),
        };
    }

    /**
     * Sets the response code.
     *
     * @param string|int $value
     * @return self
     */
    public function withCode(string|int $value): self
    {
        $this->code = $value;
        return $this;
    }

    /**
     * Sets the response status.
     *
     * @param string $value
     * @return self
     */
    public function withStatus(string $value): self
    {
        $this->status = $value;
        return $this;
    }

    /**
     * Sets the response payload.
     *
     * @param array $items
     * @return self
     */
    public function withPayload(array $items): self
    {
        $this->payload = $items;
        return $this;
    }

    /**
     * Sets the response type.
     *
     * @param string|object $type
     * @return self
     */
    public function withType(string|object $type): self
    {
        $this->type = is_object($type) ? class_basename($type) : (string) $type;
        return $this;
    }

    /**
     * Sets the response message.
     *
     * @param string $message
     * @return self
     */
    public function withMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Sets the response errors.
     *
     * @param MessageBag|array|string $errors
     * @return self
     */
    public function withErrors(MessageBag|array|string $errors): self
    {
        $this->errors = !($errors instanceof MessageBag)
            ? new MessageBag((array) $errors)
            : $errors;
        return $this;
    }

    /**
     * Checks if the response passed successfully.
     *
     * @return bool
     */
    public function passes(): bool
    {
        return $this->initialized && $this->success === true && empty($this->errors?->all());
    }

    /**
     * Checks if the response failed.
     *
     * @return bool
     */
    public function fails(): bool
    {
        return $this->initialized && $this->success === false && !empty($this->errors?->all());
    }

    /**
     * Checks if the response has a specific status.
     *
     * @param string|int $status
     * @return bool
     */
    public function hasStatus(string|int $status): bool
    {
        return $this->status === $status;
    }

    /**
     * Checks if the response has a specific status code.
     *
     * @param string|int $code
     * @return bool
     */
    public function hasStatusCode(string|int $code): bool
    {
        return $this->code === $code;
    }

    /**
     * Stores the response in the log.
     *
     * @param string $level The log level (info, warning, error, debug).
     * @return self
     */
    public function storeLog(string $level = ''): self
    {
        $level = $level ?: ($this->passes() ? 'info' : 'error');

        if (!in_array($level, ['info', 'warning', 'error', 'debug'], true)) {
            $level = 'error';
        }

        Log::log($level, $this->getMessage(), $this->getLogPayload());

        return $this;
    }

    /**
     * Logs an exception with debug information.
     *
     * @param Throwable $exception The exception to log.
     * @return self
     */
    public function debug(Throwable $exception): self
    {
        Log::debug($exception->getMessage(), [
            'code'  => $exception->getCode(),
            'file'  => $exception->getFile(),
            'line'  => $exception->getLine(),
            'trace' => $this->getExceptionTrace($exception)
        ]);

        return $this;
    }

    /**
     * Gets the main response message.
     *
     * @return string
     */
    public function getMessage(): string
    {
        if (!$this->initialized) {
            return self::error('Terjadi kesalahan tak terduga. Silakan coba lagi.')->getMessage();
        }
        return $this->message;
    }

    /**
     * Gets the status type as 'success' or 'error'.
     *
     * @return string
     */
    public function getStatusType(): string
    {
        return $this->passes() ? 'success' : 'error';
    }

    /**
     * Gets the response as an associative array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'type'    => $this->type,
            'status'  => $this->status,
            'code'    => $this->code,
            'payload' => $this->payload,
            'errors'  => $this->errors?->toArray()
        ];
    }

    /**
     * Gets the payload for logging, excluding the message.
     *
     * @return array
     */
    private function getLogPayload(): array
    {
        $payload = $this->toArray();
        unset($payload['message']);
        return $payload;
    }

    /**
     * Gets a formatted exception trace.
     *
     * @param Throwable $exception The exception to trace.
     * @param int $limit The maximum number of trace frames.
     * @return array
     */
    private function getExceptionTrace(Throwable $exception, int $limit = 5): array
    {
        $trace = array_slice($exception->getTrace(), 0, $limit);

        return array_map(
            fn ($item, $index) => sprintf(
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
     * Initializes the response instance.
     *
     * @param bool|null $success
     * @return self
     */
    private function initialize(?bool $success = null): self
    {
        if ($success !== null) {
            $this->initialized = true;
            $this->success = $success;
            $this->abort = !$success;
        }

        return $this;
    }
}
