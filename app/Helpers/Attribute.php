<?php

namespace App\Helpers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Attribute implements Arrayable
{
    protected array $attributes = [];

    public function __construct(array $attributes = [], array $defaults = [])
    {
        $this->fill($attributes, $defaults);
    }

    public static function make(array $attributes = [], array $defaults = []): static
    {
        return new static($attributes, $defaults);
    }

    public function fill(array $attributes, array $defaults = []): static
    {
        $attributes = ArrayHelper::isFlatAssoc($attributes) ? $attributes : [];
        $defaults = ArrayHelper::isFlatAssoc($defaults) ? $defaults : [];

        $this->attributes = array_merge($defaults, $attributes);
        return $this;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->attributes, $key, $default);
    }

    public function set(string $key, mixed $value): static
    {
        Arr::set($this->attributes, $key, $value);
        return $this;
    }

    public function has(string $key): bool
    {
        return Arr::has($this->attributes, $key);
    }

    public function only(array $keys): static
    {
        return static::make(Arr::only($this->attributes, $keys));
    }

    public function except(array $keys): static
    {
        return static::make(Arr::except($this->attributes, $keys));
    }

    public function merge(array $items): static
    {
        return static::make(array_merge($this->attributes, $items));
    }

    public function map(callable $callback): static
    {
        return static::make(array_map($callback, $this->attributes));
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
