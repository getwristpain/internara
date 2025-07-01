<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\MessageBag;

/**
 * Contract for LogicResponse helper which standardizes service responses.
 */
interface LogicResponseContract
{
    // ------------------------------------------------------------------------
    // Static Factory
    // ------------------------------------------------------------------------

    /**
     * Create a new response instance.
     *
     * @param bool $success
     * @param string $message
     * @param string $status
     * @param int|string $code
     * @param string $type
     * @param array $payload
     * @return static
     */
    public static function make(
        bool $success = true,
        string $message = '',
        string $status = '',
        int|string $code = 200,
        string $type = '',
        array $payload = []
    ): static;

    // ------------------------------------------------------------------------
    // Instance Mutators
    // ------------------------------------------------------------------------

    /**
     * Mark the response as successful.
     *
     * @param string $message
     * @param string $status
     * @param int|string $code
     * @return static
     */
    public function success(string $message = '', string $status = 'success', int|string $code = 200): static;

    /**
     * Mark the response as failed.
     *
     * @param string $message
     * @param string $status
     * @param int|string $code
     * @return static
     */
    public function failure(string $message = '', string $status = 'error', int|string $code = 500): static;

    /**
     * Set whether the response is successful.
     *
     * @param bool $success
     * @return static
     */
    public function setSuccess(bool $success): static;

    /**
     * Set the response message.
     *
     * @param string $message
     * @return static
     */
    public function withMessage(string $message): static;

    /**
     * Set the response status.
     *
     * @param string $status
     * @return static
     */
    public function withStatus(string $status): static;

    /**
     * Set the response code.
     *
     * @param int|string $code
     * @return static
     */
    public function withCode(int|string $code): static;

    /**
     * Set the type or class of the response.
     *
     * @param string|object $type
     * @return static
     */
    public function withType(string|object $type): static;

    /**
     * Set the response payload.
     *
     * @param Collection|array|null $payload
     * @return static
     */
    public function withPayload(Collection|array|null $payload): static;

    /**
     * Set the response errors.
     *
     * @param array|MessageBag|null $errors
     * @return static
     */
    public function withErrors(array|MessageBag|null $errors): static;

    /**
     * Add a new error to the response.
     *
     * @param string $key
     * @param string $message
     * @return static
     */
    public function addErrors(string $key, string $message): static;

    /**
     * Clear all response errors.
     *
     * @return static
     */
    public function clearErrors(): static;

    /**
     * Set the operator for the response.
     *
     * @param object|null $operator
     * @return static
     */
    public function operator(?object $operator): static;

    // ------------------------------------------------------------------------
    // Instance Accessors
    // ------------------------------------------------------------------------

    /**
     * Get the response message.
     *
     * @return string
     */
    public function getMessage(): string;

    /**
     * Get the response status.
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Get the response HTTP code.
     *
     * @return int|string
     */
    public function getCode(): int|string;

    /**
     * Get the response type.
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Get the response errors.
     *
     * @param string $key
     * @return MessageBag|array|null
     */
    public function getErrors(string $key = ''): MessageBag|array|null;

    /**
     * Get the response payload.
     *
     * @return Collection|null
     */
    public function payload(): ?Collection;

    // ------------------------------------------------------------------------
    // Core Actions
    // ------------------------------------------------------------------------

    /**
     * Return the operator if response passes; otherwise return self.
     *
     * @return mixed
     */
    public function then(): mixed;

    /**
     * Perform debugging on the failed response.
     *
     * @param \Throwable|null $exception
     * @param array $property
     * @param bool $throw
     * @return static
     */
    public function debug(?\Throwable $exception = null, array $property = [], bool $throw = false): static;

    /**
     * Store the response in the activity log.
     *
     * @return static
     */
    public function storeActivity(): static;

    /**
     * Store the response in the system log.
     *
     * @param string $level
     * @return static
     */
    public function storeLog(string $level = ''): static;

    // ------------------------------------------------------------------------
    // Utilities
    // ------------------------------------------------------------------------

    /**
     * Check if response passes.
     *
     * @return bool
     */
    public function passes(): bool;

    /**
     * Check if response fails.
     *
     * @return bool
     */
    public function fails(): bool;

    /**
     * Check if response has any errors.
     *
     * @return bool
     */
    public function hasErrors(): bool;

    /**
     * Check if the response payload is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Convert the response to an array.
     *
     * @return array
     */
    public function toArray(): array;
}
