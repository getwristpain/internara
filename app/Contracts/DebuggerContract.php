<?php

namespace App\Contracts;

/**
 * DebuggerContract defines the structure for a debugging and exception helper.
 * It provides fluent methods for exception handling, logging, throwing, and aborting.
 */
interface DebuggerContract
{
    /**
     * ------------------------------------------------------------------------
     * Static Factory and Utility Methods
     * ------------------------------------------------------------------------
     * Responsible for creating and configuring the debug instance.
     */

    /**
     * Create a debug instance and optionally log and/or throw the exception.
     *
     * @param \Throwable|string $exception
     * @param array $properties
     * @param bool $throw
     * @param bool $log
     * @return static
     */
    public static function handle(
        \Throwable|string $exception = '',
        array $properties = [],
        bool $throw = false,
        bool $log = true,
    ): static;

    /**
     * Create a debug instance from an exception or string.
     *
     * @param \Throwable|string $exception
     * @return static
     */
    public static function from(\Throwable|string $exception = ''): static;

    /**
     * Determine whether the application is in debug mode.
     *
     * @return bool
     */
    public static function isDebug(): bool;

    /**
     * ------------------------------------------------------------------------
     * Instance Mutators
     * ------------------------------------------------------------------------
     * Used to modify internal state of the debug instance.
     */

    /**
     * Set additional debug properties.
     *
     * @param array $properties
     * @return static
     */
    public function withProperties(array $properties = []): static;

    /**
     * ------------------------------------------------------------------------
     * Instance Accessors
     * ------------------------------------------------------------------------
     * Used to retrieve stored values and internal data.
     */

    /**
     * Get the exception being handled.
     *
     * @return \Throwable
     */
    public function exception(): \Throwable;

    /**
     * Get all additional debug properties.
     *
     * @return array
     */
    public function getProperties(): array;

    /**
    * Create a LogicResponse instance with this exception.
    *
    * @return \App\Helpers\LogicResponse
    */
    public function response(): \App\Helpers\LogicResponse;

    /**
     * ------------------------------------------------------------------------
     * Core Actions
     * ------------------------------------------------------------------------
     * Primary behaviors such as logging, throwing, and aborting.
     */

    /**
     * Store the debug log.
     *
     * @return static
     */
    public function storeLog(): static;

    /**
     * Immediately throw the handled exception.
     *
     * @throws \Throwable
     */
    public function throw(): never;

    /**
     * Throw the exception if the condition is true.
     *
     * @param bool $condition
     * @return static
     * @throws \Throwable
     */
    public function throwIf(bool $condition): static;

    /**
     * Throw the exception unless the condition is true.
     *
     * @param bool $condition
     * @return static
     * @throws \Throwable
     */
    public function throwIfNot(bool $condition): static;

    /**
     * Abort the request using the exception's message and code.
     *
     * @param int|null $code
     * @param array $headers
     * @return never
     */
    public function abort(?int $code = null, array $headers = []): never;

    /**
     * Abort if the condition is true.
     *
     * @param bool $condition
     * @param int|null $code
     * @param array $headers
     * @return static
     */
    public function abortIf(bool $condition, ?int $code = null, array $headers = []): static;

    /**
     * Abort unless the condition is true.
     *
     * @param bool $condition
     * @param int|null $code
     * @param array $headers
     * @return static
     */
    public function abortIfNot(bool $condition, ?int $code = null, array $headers = []): static;

    /**
     * Dump the debug data to the screen.
     *
     * @param bool $die
     * @return void
     */
    public function dump(bool $die = false): void;

    /**
     * ------------------------------------------------------------------------
     * Serialization Methods
     * ------------------------------------------------------------------------
     * Convert the instance into array representation.
     */

    /**
     * Convert the debug state to an array.
     *
     * @return array
     */
    public function toArray(): array;
}
