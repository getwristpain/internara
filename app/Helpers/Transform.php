<?php

namespace App\Helpers;

use ReflectionMethod;
use App\Helpers\Helper;
use ReflectionProperty;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Transform extends Helper
{
    protected mixed $value = null;

    public static function from(mixed $value = null): static
    {
        return (new static())->setValue($value);
    }

    /**
     * Convert any value to string.
     *
     * @param mixed $value
     * @return string
     */
    public static function stringify(mixed $value): string
    {
        return match (gettype($value)) {
            'array' => json_encode($value, JSON_PRETTY_PRINT),
            'boolean' => $value ? 'true' : 'false',
            'integer', 'double' => (string) $value,
            'object' => static::objectToString($value),
            'resource', 'resource (closed)' => 'resource',
            'string' => $value,
            'NULL' => 'NULL',
            default => 'unknown',
        };
    }

    public static function objectToString(object $object): string
    {
        return static::stringify(static::objectToArray($object));
    }

    /**
     * Convert public properties and method names to array.
     *
     * @param object $object
     * @return array
     */
    public static function objectToArray(object $object): array
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

    public function to(callable|string|null $callback = null): mixed
    {
        if (is_callable($callback)) {
            return $callback($this->value);
        }

        return match ($callback) {
            'array_array' => $this->castArray($callback),
            'array_bool', 'array_boolean' => $this->castArray($callback),
            'array_float', 'array_double' => $this->castArray($callback),
            'array_int', 'array_integer' => $this->castArray($callback),
            'array_object', 'array_obj' => $this->castArray($callback),
            'array_string', 'array_str' => $this->castArray($callback),
            'array_value', 'array_numeric' => $this->castArray($callback),
            'array' => (array) $this->value,
            'bool', 'boolean' => $this->toBoolean(),
            'float', 'double' => (float) $this->value,
            'int', 'integer' => (int) $this->value,
            'object', 'obj' => $this->toObject(),
            'string', 'str' => (string) $this->value,
            default => $this->value
        };
    }

    public function toString(mixed $value = null): string
    {
        $value ??= $this->value;

        return match (gettype($value)) {
            'string' => $value,
            'object' => method_exists($value, '__toString')
                ? (string) $value
                : static::stringify($value),
            default => static::stringify($value),
        };
    }

    public function toBoolean(mixed $value = null): bool
    {
        $value ??= $this->value;
        return filter_var($value, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE);
    }

    public function toArray(mixed $value = null): array
    {
        $value ??= $this->value;

        return match (gettype($value)) {
            'object' => method_exists($value, 'toArray')
                ? $value->toArray()
                : $this->objectToArray($value),
            default => (array) $value
        };
    }

    public function toJson(mixed $value = null): string|false
    {
        $value ??= $this->value;
        return json_encode($this->toArray($value), JSON_PRETTY_PRINT);
    }

    public function toObject(mixed $value = null): ?object
    {
        $value ??= $this->value;

        return $this->isJson($value)
            ? json_decode((string) $value)
            : (object) ['value' => $value];
    }

    public function lower(): static
    {
        if (is_string($this->value)) {
            $this->setValue(Str::lower($this->value));
        }

        return $this;
    }

    public function slug(string $separator = '-'): static
    {
        if (is_string($this->value)) {
            $this->setValue(Str::slug($this->value, $separator));
        }

        return $this;
    }

    public function replace(array|string $search = '', array|string $replace = ''): static
    {
        if (!is_string($this->value)) {
            return $this;
        }

        $this->value = Arr::isAssoc((array) $search)
            ? str_replace(array_keys($search), array_values($search), $this->value)
            : str_replace($search, $replace, $this->value);

        return $this;
    }

    public function initials(): static
    {
        if (!is_string($this->value)) {
            return $this;
        }

        $this->value = Str::of($this->value)
            ->explode(' ')
            ->map(fn ($w) => trim($w))
            ->filter(fn ($w) => $w !== '')
            ->map(function ($w) {
                if (Str::contains($w, '-')) {
                    $parts = explode('-', $w);
                    foreach ($parts as $p) {
                        $p = trim($p);
                        if ($p !== '' && ctype_upper(Str::substr($p, 0, 1))) {
                            return Str::substr($p, 0, 1);
                        }
                    }

                    return null;
                }

                return ctype_upper(Str::substr($w, 0, 1))
                    ? Str::substr($w, 0, 1)
                    : null;
            })
            ->filter()
            ->implode('');

        return $this;
    }

    protected function castArray(string $type): mixed
    {
        $array = $this->to('array');

        return match ($type) {
            'array_array' => (array) array_map(fn ($v) => (array) $v, $array),
            'array_bool', 'array_boolean' => array_map(fn ($v) => $this->toBoolean($v), $array),
            'array_float', 'array_double' => array_map(fn ($v) => (float) $v, $array),
            'array_int', 'array_integer' => array_map(fn ($v) => (int) $v, $array),
            'array_object', 'array_obj' => array_map(fn ($v) => $this->toObject($v), $array),
            'array_string', 'array_str' => array_map(fn ($v) => (string) $v, $array),
            'array_value', 'array_numeric' => (array) array_values($array),
            default => (array) $array
        };
    }

    protected function setValue(mixed $value = null): static
    {
        $this->value = $value;
        return $this;
    }

    protected function isJson(string $value = ''): bool
    {
        $value ??= $this->value;

        if (is_numeric($value)) {
            return false;
        }

        if (!is_string($value)) {
            return false;
        }

        json_decode($value);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
