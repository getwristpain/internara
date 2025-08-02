<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;
use InvalidArgumentException;

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
        $instance->setSuccess($success)
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
        $instance->setSuccess(true)
            ->with('message', $message)
            ->clearErrors();

        return $instance;
    }

    public static function fail(string $message): static
    {
        $instance = new static();
        $instance->setSuccess(false)
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
            'error', 'success' => $this->withMessage($value, $attributes),
            'type' => $this->withType($value),
            default => $this->fill($attributes, $value)
        };
    }

    public function withType(string|object|null $type): static
    {
        if (is_object($type)) {
            $type = class_basename($type);
        }

        $this->type = $type;
        return $this;
    }

    public function withMessage(string $message = '', string $flag = ''): static
    {
        $this->message = match (true) {
            ($flag === 'success') && $this->passes() => $message,
            ($flag === 'error') && $this->fails() => $message,
            default => $this->message
        };

        return $this;
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
    public function passes(): bool|int
    {
        return $this->success && empty($this->errors);
    }

    public function fails(): bool|int
    {
        return !$this->success && $this->errors && $this->errors->isNotEmpty();
    }

    public function storeLog(string $level = ''): static
    {
        if (empty($level)) {
            $level = $this->success ? 'success' : 'error';
        }

        $level = in_array($level, ['success', 'info', 'warning', 'error', 'debug'], true);
        $context = $this->toArray();

        unset($context['message']);
        Log::log($level, $this->message, $context);

        return $this;
    }

    public function debug(?\Throwable $th = null): static
    {
        if (!($th instanceof \Exception)) {
            throw $th;
        }

        Log::debug($th->getMessage(), [
            'code' => $th->getCode(),
            'file' => $th->getFile(),
            'line' => $th->getLine(),
            'trace' => $th->getTraceAsString()
        ]);

        return $this;
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'type' => $this->type,
            'code' => $this->code,
            'payload' => $this->payload,
            'errors' => $this->errors?->all()
        ];
    }

    protected function fill(string $attribute, mixed $value): static
    {
        if (property_exists($this, $attribute)) {
            throw new InvalidArgumentException("The '$attribute' attribute not found.");
        }

        $this->$attribute = $value;
        return $this;
    }

    protected function setSuccess(bool $value = true): static
    {
        $this->init = true;
        $this->success = $value;

        return $this;
    }
}
