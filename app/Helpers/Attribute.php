<?php

namespace App\Helpers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Attribute implements Arrayable
{
    protected array $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    public static function make(array $attributes = []): static
    {
        return new static($attributes);
    }

    public function fill(array $attributes): static
    {
        if (!empty($attributes) && !Helper::isFlatAssocArray($attributes)) {
            throw new \InvalidArgumentException('Attributes array must be a flat associative array.');
        }

        $this->attributes = $attributes;
        return $this;
    }

    public function get(string|int|array $key = '', mixed $default = null): mixed
    {
        if (empty($key)) {
            return $this->attributes;
        }

        return Helper::getArray($this->attributes, $key, $default);
    }

    public function set(string|int|array $key, mixed $value): static
    {
        Helper::setArray($this->attributes, $key, $value);
        return $this;
    }

    public function has(string $key): bool
    {
        return Arr::has($this->attributes, $key);
    }

    public function only(array $keys): static
    {
        return $this->fill(Arr::only($this->attributes, $keys));
    }

    public function except(array $keys): static
    {
        return $this->fill(Arr::except($this->attributes, $keys));
    }

    public function merge(array $items): static
    {
        return $this->fill(array_merge($this->attributes, $items));
    }

    public function map(callable $callback): static
    {
        return $this->fill(array_map($callback, $this->attributes));
    }

    public function isEmpty(): bool
    {
        return empty($this->attributes);
    }

    public function toArray(): array
    {
        return $this->attributes;
    }

    public function toCollection(): Collection
    {
        return collect($this->attributes);
    }

    public function __get(string $key)
    {
        return $this->get($key);
    }

    public function __set(string $key, $value)
    {
        $this->set($key, $value);
    }

    public function __isset(string $key): bool
    {
        return $this->has($key);
    }
}
