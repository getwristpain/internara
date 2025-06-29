<?php

namespace App\Helpers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Attribute helper for managing flat associative arrays with utility methods.
 */
class Attribute extends Helper implements Arrayable
{
    /**
     * The underlying attributes array.
     *
     * @var array
     */
    protected array $attributes = [];

    /**
     * Create a new Attribute instance.
     *
     * @param array $attributes
     * @return static
     */
    public static function make(array $attributes = []): static
    {
        return (new static())
            ->fill($attributes);
    }

    /**
     * Fill the attribute array.
     *
     * @param array $attributes
     * @return static
     */
    public function fill(array $attributes): static
    {
        if (!empty($attributes) && !Support::isFlatAssocArray($attributes)) {
            Debugger::handle(exception: new \InvalidArgumentException('Attributes array must be a flat associative array.'))->throw();
        }

        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Get a value from the attributes array.
     *
     * @param string|int|array $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string|int|array $key = '', mixed $default = null): mixed
    {
        return $key === '' ? $this->attributes : Support::getArray($this->attributes, $key, $default);
    }

    /**
     * Set a value in the attributes array.
     *
     * @param string|int|array $key
     * @param mixed $value
     * @return static
     */
    public function set(string|int|array $key, mixed $value): static
    {
        Support::setArray($this->attributes, $key, $value);
        return $this;
    }

    /**
     * Determine if the given key exists in the attributes.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return Arr::has($this->attributes, $key);
    }

    /**
     * Get only the specified keys from the attributes.
     *
     * @param array $keys
     * @return static
     */
    public function only(array $keys): static
    {
        return $this->fill(Arr::only($this->attributes, $keys));
    }

    /**
     * Get all attributes except the specified keys.
     *
     * @param array $keys
     * @return static
     */
    public function except(array $keys): static
    {
        return $this->fill(Arr::except($this->attributes, $keys));
    }

    /**
     * Merge the given items into the attributes.
     *
     * @param array $items
     * @return static
     */
    public function merge(array $items): static
    {
        return $this->fill(array_merge($this->attributes, $items));
    }

    /**
     * Map the attributes using the given callback.
     *
     * @param callable $callback
     * @return static
     */
    public function map(callable $callback): static
    {
        return $this->fill(array_map($callback, $this->attributes));
    }

    /**
     * Determine if the attributes array is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->attributes);
    }

    /**
     * Get the attributes as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    /**
     * Get the attributes as a collection.
     *
     * @return Collection
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }

    /**
     * Magic getter for attributes.
     *
     * @param string $key
     * @return mixed
     */
    public function __get(string $key): mixed
    {
        return $this->get($key);
    }

    /**
     * Magic setter for attributes.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function __set(string $key, mixed $value): void
    {
        $this->set($key, $value);
    }

    /**
     * Magic isset for attributes.
     *
     * @param string $key
     * @return bool
     */
    public function __isset(string $key): bool
    {
        return $this->has($key);
    }
}
