<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;
use InvalidArgumentException;
use Throwable;

class LogicResponse
{
    protected bool $initialized = false;
    protected ?bool $success = null;
    protected string $message = '';
    protected string $type = 'Response';
    protected string $status = '';
    protected string|int $code = '';
    protected array $payload = [];
    protected ?MessageBag $errors = null;
    protected bool $abort = false;

    /** ===== Static Factory ===== */
    public static function make(
        bool $success = true,
        string $message = '',
        string $type = 'Response',
        string $status = '',
        string|int $code = '',
        mixed $payload = []
    ): static {
        $instance = new static();
        $instance->initialize($success)
            ->withMessage($message)
            ->withType($type)
            ->withStatus($status)
            ->withCode($code)
            ->withPayload($payload);

        $success
            ? $instance->clearErrors()
            : $instance->withErrors($message);

        return $instance;
    }

    /**
     * @param bool|callable:bool $condition
     *
     * @return static
     */
    public function decide(bool|callable $condition, string $successMessage = '', string $errorMessage = ''): static
    {
        return (bool) $condition ?? false
            ? $this->success($successMessage)
            : $this->error($errorMessage);
    }

    public static function success(string $message = ''): static
    {
        return (new static())->make(true, $message);
    }

    public static function error(string $message = ''): static
    {
        return (new static())->make(false, $message);
    }

    /** ===== Conditional Fail ===== */

    /**
     * @param LogicResponse|(callable(LogicResponse): LogicResponse|bool)|bool $condition
     * @param string $message
     *
     * @return static
     */
    public function failWhen(LogicResponse|callable|bool $condition, string $message = ''): static
    {
        if ($this->abort) {
            return $this;
        }

        if ($condition instanceof LogicResponse) {
            return $condition->fails()
                ? (empty($message) ? $condition : $condition->with('message', $message))
                : $this;
        }

        if (is_callable($condition)) {
            $result = $condition($this);

            if ($result instanceof LogicResponse) {
                return $result->fails() ? $result : $this;
            }

            if (is_bool($result)) {
                return $result ? static::error($message) : $this;
            }

            throw new InvalidArgumentException(
                sprintf('The $condition must return LogicResponse or boolean. %s given.', gettype($result))
            );
        }

        return $condition ? static::error($message) : $this;
    }

    /** ===== Callback Chaining ===== */
    /**
     * @param (callable(LogicResponse))|mixed|null $callback
     *
     * @return mixed
     */
    public function then(mixed $callback = null): mixed
    {
        if ($this->abort) {
            return $this;
        }

        return is_callable($callback) ? $callback($this) : ($callback ?: $this);
    }

    /** ===== Modifiers ===== */
    public function clearErrors(): static
    {
        $this->errors = null;
        return $this;
    }

    public function with(string|array $attributes, mixed $value = null): static
    {
        if (is_array($attributes)) {
            foreach ($attributes as $attr => $val) {
                $this->with($attr, $val);
            }
            return $this;
        }

        return match ($attributes) {
            'message' => $this->withMessage($value),
            'type'    => $this->withType($value),
            'status'  => $this->withStatus($value),
            'code'    => $this->withCode($value),
            'payload' => $this->withPayload($value),
            'errors'  => $this->withErrors($value),
            default   => throw new InvalidArgumentException("Attribute '{$attributes}' not found"),
        };
    }

    public function withCode(string|int $value = ''): static
    {
        $this->code = $value ?: ($this->passes() ? 'SUCCESS' : 'ERROR');
        return $this;
    }

    public function withStatus(string $value = ''): static
    {
        $this->status = $value ?: ($this->passes() ? 'success' : 'error');
        return $this;
    }

    public function withPayload(array $items = []): static
    {
        $this->payload = $items;
        return $this;
    }

    public function withType(string|object|null $type): static
    {
        $this->type = is_object($type) ? class_basename($type) : (string) $type;
        return $this;
    }

    public function withMessage(string $message = '', string|bool $flag = ''): static
    {
        if (is_bool($flag)) {
            $flag = $flag ? 'success' : 'error';
        }

        $this->message = match (true) {
            $flag === 'success' && $this->passes() => $message,
            $flag === 'error' && $this->fails()    => $message,
            default => $message ?: ($this->fails() ? 'Terjadi kesalahan sistem: tidak diketahui.' : '')
        };

        return $this;
    }

    public function withErrors(MessageBag|array|string|null $errors): static
    {
        $this->errors = !($errors instanceof MessageBag)
            ? new MessageBag((array) $errors)
            : $errors;

        return $this;
    }

    /** ===== Status Check ===== */
    public function passes(): bool
    {
        return $this->initialized && $this->success === true && empty($this->errors);
    }

    public function fails(): bool
    {
        return $this->initialized && $this->success === false && $this->errors && $this->errors->isNotEmpty();
    }

    /** ===== Logging ===== */
    public function storeLog(string $level = ''): static
    {
        $level = $level ?: ($this->success ? 'success' : 'error');

        if (!in_array($level, ['success', 'info', 'warning', 'error', 'debug'], true)) {
            $level = 'error';
        }

        Log::log($level, $this->message, array_diff_key($this->toArray(), ['message' => true]));

        return $this;
    }

    public function debug(?Throwable $exception = null): static
    {
        if (!$exception instanceof Throwable) {
            return $this;
        }

        Log::debug($exception->getMessage(), [
            'code'  => $exception->getCode(),
            'file'  => $exception->getFile(),
            'line'  => $exception->getLine(),
            'trace' => $this->formatExceptionTrace($exception)
        ]);

        return $this;
    }

    /** ===== Getters ===== */
    public function getMessage(): string
    {
        if (!$this->initialized) {
            return static::error('Terjadi kesalahan sistem: tidak diketahui.')->getMessage();
        }
        return $this->message;
    }

    public function getStatusType(): string
    {
        return $this->passes() ? 'success' : 'error';
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'type'    => $this->type,
            'status'  => $this->status,
            'code'    => $this->code,
            'payload' => $this->payload,
            'errors'  => $this->errors?->all()
        ];
    }

    /** ===== Internal Helpers ===== */
    protected function formatExceptionTrace(?Throwable $exception = null, int $limit = 5): ?array
    {
        if (!$exception) {
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

    protected function initialize(?bool $success = null): static
    {
        if ($success !== null) {
            $this->initialized = true;
            $this->success = $success;
            $this->abort = !$success;
        }

        return $this;
    }
}
