<?php

namespace App\Helpers;

use ReflectionMethod;
use ReflectionProperty;

class Transform
{
    /**
     * @var mixed The value to be transformed.
     */
    private mixed $value = null;

    /**
     * The constructor is private to enforce using the static factory.
     *
     * @param mixed $value
     */
    private function __construct(mixed $value)
    {
        $this->value = $value;
    }

    // --- Static Factory ---

    /**
     * Creates a new instance of the Transform helper.
     *
     * @param mixed $value
     * @return self
     */
    public static function from(mixed $value = null): self
    {
        return new self($value);
    }

    // --- Public Getters ---

    /**
     * Gets the current value.
     *
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    // --- Public Casting Methods ---

    /**
     * Casts the value to a string.
     *
     * @return string
     */
    public function toString(): string
    {
        return $this->castToString($this->value);
    }

    /**
     * Casts the value to a boolean.
     *
     * @return bool
     */
    public function toBoolean(): bool
    {
        return $this->castToBoolean($this->value);
    }

    /**
     * Casts the value to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        if (is_object($this->value) && method_exists($this->value, 'toArray')) {
            return $this->value->toArray();
        }

        return is_object($this->value)
            ? $this->objectToArray($this->value)
            : (array) $this->value;
    }

    /**
     * Casts the value to a JSON string.
     *
     * @return string|false
     */
    public function toJson(): string|false
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }

    /**
     * Casts the value to an object.
     *
     * @return object
     */
    public function toObject(): object
    {
        return $this->isJson($this->value)
            ? json_decode($this->value)
            : (object) ['value' => $this->value];
    }

    // --- Private Helper Methods (Internal Logic) ---

    /**
     * Converts a value to a string based on its type.
     *
     * @param mixed $value
     * @return string
     */
    private function castToString(mixed $value): string
    {
        return match (gettype($value)) {
            'array' => json_encode($value, JSON_PRETTY_PRINT),
            'boolean' => $value ? 'true' : 'false',
            'integer', 'double' => (string) $value,
            'object' => method_exists($value, '__toString') ? (string) $value : $this->objectToString($value),
            'resource', 'resource (closed)' => 'resource',
            'string' => $value,
            'NULL' => 'NULL',
            default => 'unknown',
        };
    }

    /**
     * Converts a value to a boolean.
     *
     * @param mixed $value
     * @return bool
     */
    private function castToBoolean(mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) ?? false;
    }

    /**
     * Checks if a string is valid JSON.
     *
     * @param mixed $value
     * @return bool
     */
    private function isJson(mixed $value): bool
    {
        if (!is_string($value) || is_numeric($value)) {
            return false;
        }
        json_decode($value);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Converts a public object to an array.
     *
     * @param object $object
     * @return array
     */
    private function objectToArray(object $object): array
    {
        $reflection = new \ReflectionClass($object);
        $data = [];
        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $prop) {
            $name = $prop->getName();
            try {
                $data[$name] = $prop->isInitialized($object) ? $prop->getValue($object) : null;
            } catch (\Throwable $e) {
                $data[$name] = null;
            }
        }
        $methods = array_filter(
            array_map(fn (ReflectionMethod $m) => $m->getName(), $reflection->getMethods(ReflectionMethod::IS_PUBLIC)),
            fn ($name) => !str_starts_with($name, '__')
        );
        if (!empty($methods)) {
            $data['methods'] = array_values($methods);
        }
        return $data;
    }

    /**
     * Converts an object to a string by first converting it to an array.
     *
     * @param object $object
     * @return string
     */
    private function objectToString(object $object): string
    {
        return $this->castToString($this->objectToArray($object));
    }
}
