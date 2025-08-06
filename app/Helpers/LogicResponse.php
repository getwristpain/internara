<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;

class LogicResponse
{
    protected bool $initialized = false;

    protected bool $success = true;

    protected string $message = '';

    protected string $type = 'Response';

    protected string $status = 'success';

    protected string|int $code = 'SUCCESS';

    protected array $payload = [];

    protected ?MessageBag $errors = null;

    protected bool $abort = false;

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

    public static function success(string $message = ''): static
    {
        $instance = new static();
        $instance->setSuccess(true)
            ->with('message', $message)
            ->clearErrors();

        return $instance;
    }

    public static function fail(string $message = ''): static
    {
        $instance = new static();
        $instance->setSuccess(false)
            ->with('message', $message)
            ->with('errors', ['message' => $message]);

        return $instance;
    }

    /**
     * @param LogicResponse|(callable(LogicResponse):LogicResponse)|bool $condition
     * @param string $message
     *
     * @return LogicResponse
     */
    public function failWhen(LogicResponse|callable|bool $condition, string $message = ''): static
    {
        if ($this->abort) {
            return $this;
        }

        if ($condition instanceof LogicResponse && $condition->fails()) {
            return empty($message) ? $condition : $condition->with('error', $message);
        }

        if (is_callable($condition)) {
            $callback = $condition($this);

            if ($callback instanceof LogicResponse && $callback->fails()) {
                return $callback;
            }

            throw new \InvalidArgumentException('The $condition must return LogicResponse or boolean. ' . gettype($callback) . ' given.');
        }

        return $condition ? $this->fail($message) : $this;
    }

    /**
     * @param (callable(LogicResponse))|mixed|null $callback
     *
     * @return LogicResponse|mixed
     */
    public function then(mixed $callback = null): mixed
    {
        if ($this->abort) {
            return $this;
        }

        if (is_callable($callback)) {
            return $callback($this);
        }

        return empty($callback) ? $this : $callback;
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
    public function passes(): bool
    {
        return $this->success && empty($this->errors);
    }

    public function fails(): bool
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

    public function debug(?\Throwable $exception = null): static
    {
        if (!($exception instanceof \Exception)) {
            throw $exception;
        }

        Log::debug($exception->getMessage(), [
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $this->formatExceptionTrace($exception)
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

    protected function formatExceptionTrace(?\Throwable $exception = null, int $limit = 5): ?array
    {
        if (empty($exception)) {
            return null;
        }

        $trace = array_slice($exception->getTrace(), 0, $limit);

        return array_map(
            fn ($item, $index) =>
                sprintf(
                    '#%d %s(%s): %s%s%s',
                    $index,
                    $item['file'] ?? '[internal function]',
                    $item['line'] ?? '-',
                    $item['class'] ?? '',
                    $item['type'] ?? '',
                    $item['function'] ?? ''
                ),
            $trace,
            array_keys($trace)
        );
    }

    protected function fill(string $attribute, mixed $value): static
    {
        if (property_exists($this, $attribute)) {
            throw new \InvalidArgumentException("The '$attribute' attribute not found.");
        }

        $this->$attribute = $value;
        return $this;
    }

    protected function setSuccess(bool $value = true): static
    {
        $this->initialized = true;
        $this->success = $value;
        $this->abort = !$value;

        return $this;
    }
}
