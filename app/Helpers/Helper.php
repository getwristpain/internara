<?php

namespace App\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use Illuminate\Support\Collection;

/**
 * ------------------------------------------------------------------------
 * Base Utility Helper
 * ------------------------------------------------------------------------
 * Abstract base class for all custom helpers. Provides core data access,
 * property management, and access to Laravel Support components.
 */
abstract class Helper
{
    /**
     * ------------------------------------------------------------------------
     * Static Factory and Utility Methods
     * ------------------------------------------------------------------------
     * Provides access to Laravel Support classes and utility instances.
     */

    /**
     * Get the Arr helper instance.
     *
     * @return Arr
     */
    protected static function arr(): Arr
    {
        return new Arr();
    }

    /**
     * Get the Str helper instance.
     *
     * @return Str
     */
    protected static function str(): Str
    {
        return new Str();
    }

    /**
     * Get the Number helper instance.
     *
     * @return Number
     */
    protected static function number(): Number
    {
        return new Number();
    }

    /**
     * Get the Carbon helper instance.
     *
     * @return Carbon
     */
    protected static function carbon(): Carbon
    {
        return new Carbon();
    }

    /**
     * Create a new Collection instance.
     *
     * @param array $items
     * @return Collection
     */
    protected static function collect(array $items = []): Collection
    {
        return collect($items);
    }

    /**
     * ------------------------------------------------------------------------
     * Instance Mutators
     * ------------------------------------------------------------------------
     * Allow dynamic setting of public properties, if available.
     */

    /**
     * Set a property value if the property exists.
     *
     * @param string $property
     * @param mixed $value
     * @return void
     */
    protected function setProperty(string $property, mixed $value): void
    {
        if (property_exists($this, $property)) {
            $this->{$property} = $value;
        }
    }

    /**
     * ------------------------------------------------------------------------
     * Instance Accessors
     * ------------------------------------------------------------------------
     * Retrieve values from the current object dynamically.
     */

    /**
     * Get a property value if it exists, otherwise return the default.
     *
     * @param string $property
     * @param mixed $default
     * @return mixed
     */
    protected function getProperty(string $property, mixed $default = null): mixed
    {
        return property_exists($this, $property) ? $this->{$property} : $default;
    }

    /**
     * ------------------------------------------------------------------------
     * Core Actions
     * ------------------------------------------------------------------------
     * Main behaviors such as response conversion and type casting.
     */

    /**
     * Create a LogicResponse instance with this type and payload.
     *
     * @return LogicResponse
     */
    protected function response(): LogicResponse
    {
        return LogicResponse::make()
            ->withType($this)
            ->withPayload($this->toArray())
            ->operator($this);
    }

    /**
     * Convert the object to string using its public properties.
     *
     * @return string
     */
    public function __toString(): string
    {
        return Support::stringify(Support::objectToArray($this));
    }

    /**
     * ------------------------------------------------------------------------
     * Serialization Methods
     * ------------------------------------------------------------------------
     * Convert internal object state to array or JSON format.
     */

    /**
     * Convert the object to array.
     *
     * @return array
     */
    protected function toArray(): array
    {
        return Support::objectToArray($this);
    }

    /**
     * Convert the object to JSON.
     *
     * @return string|false
     */
    protected function toJson(): string|false
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }
}
