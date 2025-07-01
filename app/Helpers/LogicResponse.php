<?php

namespace App\Helpers;

use App\Contracts\LogicResponseContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;
use Spatie\Activitylog\Facades\Activity;

/**
 * LogicResponse is a helper class that standardizes service outcomes,
 * supports method chaining, and offers logging or debugging capabilities.
 */
class LogicResponse extends Helper implements LogicResponseContract
{
    /**
     * ------------------------------------------------------------------------
     * Core State
     * ------------------------------------------------------------------------
     * Fundamental response state: success flag, code, message, and status.
     */

    /** @var bool Indicates whether the response has been initialized. */
    protected bool $initial = false;

    /** @var bool Indicates whether the response is successful. */
    protected bool $success = true;

    /** @var string Response status string such as 'success', 'error'. */
    protected string $status = '';

    /** @var int HTTP-compatible response code. */
    protected int|string $code = 200;

    /** @var string The message describing the response. */
    protected string $message = '';

    /** @var string The type or context of the response (usually class name). */
    protected string $type = '';

    /**
     * ------------------------------------------------------------------------
     * Payload & Metadata
     * ------------------------------------------------------------------------
     * Holds the data payload, error messages, and source operator.
     */

    /** @var Collection|null Response payload as collection of data. */
    protected ?Collection $payload = null;

    /** @var MessageBag|null Validation or system errors. */
    protected ?MessageBag $errors = null;

    /** @var object|null Optional operator instance related to this response. */
    protected ?object $operator = null;

    /** @var array Allowed log levels for storeLog(). */
    protected array $allowedLevel = [
        'info', 'debug', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'
    ];

    /**
     * ------------------------------------------------------------------------
     * Static Factory
     * ------------------------------------------------------------------------
     * Create a new LogicResponse instance with default or given values.
     */

    /**
     * Create a new response instance.
     *
     * @param bool $success Whether the response is successful.
     * @param string $message Message describing the result.
     * @param string $status Response status string.
     * @param int|string $code HTTP-compatible response code.
     * @param string $type Type or context of the response.
     * @param array $payload Data payload to attach.
     * @return static
     */
    public static function make(
        bool $success = true,
        string $message = '',
        string $status = '',
        int|string $code = 0,
        string $type = '',
        array $payload = []
    ): static {
        $instance = new static();

        return ($success ? $instance->success($message) : $instance->failure($message))
            ->withStatus($status ?: ($success ? 'success' : 'error'))
            ->withCode($code !== 0 ? $code : ($success ? 200 : 500))
            ->withType($type ?: $instance)
            ->withPayload($payload);
    }

    /**
     * ------------------------------------------------------------------------
     * Instance Mutators
     * ------------------------------------------------------------------------
     * Configure response state and properties.
     */

    /**
     * Mark the response as successful.
     *
     * @param string $message
     * @param string $status
     * @param int|string $code
     * @return static
     */
    public function success(string $message = '', string $status = 'success', int|string $code = 200): static
    {
        return $this->initialized()
            ->setSuccess(true)
            ->withMessage($message)
            ->withStatus($status)
            ->withCode($code)
            ->clearErrors();
    }

    /**
     * Mark the response as failed.
     *
     * @param string $message
     * @param string $status
     * @param int|string $code
     * @return static
     */
    public function failure(string $message = '', string $status = 'error', int|string $code = 500): static
    {
        return $this->initialized()
            ->setSuccess(false)
            ->withMessage($message)
            ->withStatus($status)
            ->withCode($code)
            ->withErrors(['messages' => [$this->getMessage()]]);
    }

    /**
     * Set whether the response is successful.
     *
     * @param bool $success
     * @return static
     */
    public function setSuccess(bool $success): static
    {
        $this->success = $success;
        return $this;
    }

    /**
     * Set the response message.
     *
     * @param string $message
     * @return static
     */
    public function withMessage(string $message): static
    {
        $this->message = Sanitizer::sanitize($message, 'message');
        return $this;
    }

    /**
     * Set the response status string.
     *
     * @param string $status
     * @return static
     */
    public function withStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Set the response HTTP code.
     *
     * @param int|string $code
     * @return static
     */
    public function withCode(int|string $code): static
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Set the type or context for the response.
     *
     * @param string|object $type
     * @return static
     */
    public function withType(string|object $type): static
    {
        $this->type = is_object($type) ? get_class($type) : $type;
        return $this;
    }

    /**
     * Set the response payload.
     *
     * @param Collection|array|null $payload
     * @return static
     */
    public function withPayload(Collection|array|null $payload): static
    {
        $this->payload = new Collection($payload instanceof Collection ? $payload->toArray() : $payload ?? []);
        return $this;
    }

    /**
     * Set the response errors.
     *
     * @param array|MessageBag|null $errors
     * @return static
     */
    public function withErrors(array|MessageBag|null $errors): static
    {
        if ($this->passes()) {
            return $this;
        }

        $this->errors = match (true) {
            $errors instanceof MessageBag => $errors,
            is_array($errors)      => new MessageBag($errors),
            default                       => null,
        };

        return $this;
    }

    /**
     * Add a new error to the response.
     *
     * @param string $key
     * @param string $message
     * @return static
     */
    public function addErrors(string $key, string $message): static
    {
        if ($this->passes()) {
            return $this;
        }

        $this->errors ??= new MessageBag();
        $this->errors->add($key, $message);

        return $this;
    }

    /**
     * Clear all response errors.
     *
     * @return static
     */
    public function clearErrors(): static
    {
        $this->errors = null;
        return $this;
    }

    /**
     * Set the operator instance (only if response passes).
     *
     * @param object|null $operator
     * @return static
     */
    public function operator(?object $operator): static
    {
        if ($operator instanceof LogicResponse) {
            return $this;
        }

        $this->operator = $this->passes() ? $operator : null;
        return $this;
    }

    /**
     * ------------------------------------------------------------------------
     * Instance Accessors
     * ------------------------------------------------------------------------
     * Get current state of the response.
     */

    /**
     * Get the response message.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Get the response status.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Get the response HTTP code.
     *
     * @return int|string
     */
    public function getCode(): int|string
    {
        return $this->code;
    }

    /**
     * Get the response type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get the response errors.
     *
     * @param string $key
     * @return MessageBag|array|null
     */
    public function getErrors(string $key = ''): MessageBag|array|null
    {
        return $this->errors ? ($key ? $this->errors->get($key) : $this->errors) : null;
    }

    /**
     * Get the response payload.
     *
     * @return Collection|null
     */
    public function payload(): ?Collection
    {
        return $this->fails() ? null : $this->payload;
    }

    /**
     * ------------------------------------------------------------------------
     * Core Actions
     * ------------------------------------------------------------------------
     * Behaviors like debug, logging, activity, and chaining.
     */

    /**
     * Return operator if passes, or return self.
     *
     * @return mixed
     */
    public function then(): mixed
    {
        return $this->fails() ? $this : ($this->operator ?? $this);
    }

    /**
     * Debug this response with optional exception and context.
     *
     * @param \Throwable|string $exception
     * @param array $property
     * @param bool $throw
     * @return static
     */
    public function debug(\Throwable|string|null $exception = null, array $property = [], bool $throw = false): static
    {
        if ($this->fails()) {
            Debugger::handle(
                exception: $exception ?? $this->getMessage(),
                properties: array_merge($property, [
                    'response' => $this->toArray(),
                ]),
                throw: $throw
            );
        }

        return $this;
    }

    /**
     * Store activity log if response passes.
     *
     * @return static
     */
    public function storeActivity(): static
    {
        if (!$this->passes()) {
            return $this->failure('Failed to store activity log: Undefined response.');
        }

        Activity::withProperties($this->toArray())
            ->event($this->getStatus() ?: $this->getType() ?: 'response')
            ->log($this->getMessage());

        return $this;
    }

    /**
     * Store system log using Laravel's Log facade.
     *
     * @param string $level
     * @return static
     */
    public function storeLog(string $level = ''): static
    {
        if (!$this->isInitialized()) {
            return $this->failure('Failed to store system log: Undefined response.');
        }

        $level = Sanitizer::sanitize($level, 'filter', $this->allowedLevel);
        $level = $level ?: ($this->passes() ? 'info' : 'error');

        Log::log($level, $this->getMessage(), $this->toArray());

        return $this;
    }

    /**
     * ------------------------------------------------------------------------
     * Internal Utilities
     * ------------------------------------------------------------------------
     * Internal logic utilities for managing state.
     */

    /**
     * Mark the response as initialized.
     *
     * @return static
     */
    protected function initialized(): static
    {
        $this->initial = true;
        return $this;
    }

    /**
     * Check if the response has been initialized.
     *
     * @return bool
     */
    protected function isInitialized(): bool
    {
        return $this->initial;
    }

    /**
     * Check whether the response is valid and successful.
     *
     * @return bool
     */
    public function passes(): bool
    {
        return $this->isInitialized() && !$this->hasErrors() && $this->success;
    }

    /**
     * Check whether the response is invalid or failed.
     *
     * @return bool
     */
    public function fails(): bool
    {
        return $this->isInitialized() && !$this->success;
    }

    /**
     * Check if the response contains errors.
     *
     * @return bool
     */
    public function hasErrors(): bool
    {
        return $this->errors instanceof MessageBag && $this->errors->isNotEmpty();
    }

    /**
     * Check if the payload is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->payload()?->toArray() ?? null);
    }

    /**
     * Convert the response to an array representation.
     *
     * @return array
     */
    public function toArray(): array
    {
        if (!$this->isInitialized()) {
            return [];
        }

        return Support::filter([
            'success' => $this->passes(),
            'message' => $this->getMessage(),
            'status'  => $this->getStatus(),
            'code'    => $this->getCode(),
            'type'    => $this->getType(),
            'payload' => $this->payload()?->toArray(),
            'errors'  => $this->getErrors() instanceof MessageBag ? $this->getErrors()->toArray() : null,
        ]);
    }
}
