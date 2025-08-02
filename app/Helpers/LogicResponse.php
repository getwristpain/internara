<?php

namespace App\Helpers;

use Illuminate\Support\MessageBag;

class LogicResponse
{
    protected bool $init = false;

    protected bool $success = true;

    protected string $message = '';

    protected string $type = 'Response';

    protected string $status = 'success';

    protected string|int $code = 'SUCCESS';

    protected array $payload = [];

    protected ?MessageBag $errors = null;

    public static function make(bool $success = true, string $message = '', string $type = 'Response'): static
    {
        $instance = new static();
        $instance->init($success)
            ->with('message', $message)
            ->with('type', $type);

        $success
            ? $instance->clearErrors()
            : $instance->with('errors', ['message' => $message]);

        return $instance;
    }

    public static function success(string $message): static
    {
        $instance = new static();
        $instance->init(true)
            ->with('message', $message)
            ->clearErrors();

        return $instance;
    }

    public static function fail(string $message): static
    {
        $instance = new static();
        $instance->init(false)
            ->with('message', $message)
            ->with('errors', ['message' => $message]);

        return $instance;
    }

    public function clearErrors(): static
    {
        $this->errors = null;
        return $this;
    }

    public function with(string|array $attributes, mixed $value): static
    {
        if (is_array($attributes)) {
            foreach ($attributes as $attr => $v) {
                $this->with($attr, $v);
            }
        }

        return match ($attributes) {
            'errors' => $this->withErrors($value),
            default => $this->fill($attributes, $value)
        };
    }

    public function withErrors(MessageBag|array|null $errors): static
    {
        if (!($errors instanceof MessageBag)) {
            $this->errors = new MessageBag($errors ?? []);

            return $this;
        }

        $this->errors = $errors;

        return $this;
    }

    protected function fill(string $attribute, mixed $value): static
    {
        if (property_exists($this, $attribute)) {
            $this->$attribute = $value;
        }

        return $this;
    }

    protected function init(bool $success = true): static
    {
        $this->init = true;
        $this->success = $success;

        return $this;
    }
}
