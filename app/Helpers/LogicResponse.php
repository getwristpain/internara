<?php

namespace App\Helpers;

use App\Contracts\LogicResponseContract;
use App\Helpers\Helper;
use App\Helpers\Sanitizer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;
use Spatie\Activitylog\Facades\Activity;

class LogicResponse extends Helper implements LogicResponseContract
{
    protected bool $initial = false;

    protected bool $success = true;

    protected string $message = '';

    protected string $status = '';

    protected int $code = 0;

    protected string $type = '';

    protected ?Collection $payload = null;

    protected ?object $operator = null;

    protected MessageBag|Collection|null $errors = null;

    protected array $allowedLevel = ['info', 'debug', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'];

    public static function response(bool $success, string $message = '', string $status = '', int $code = 0, string $type = '', array $payload = []): static
    {
        $instance = new static();
        $response = $success ? $instance->success($message) : $instance->failure($message);

        return $response
            ->withStatus($status ?? '')
            ->withCode($code ?? 0)
            ->withType($type ?? '')
            ->withPayload($payload ?? []);
    }

    public function success(string $message = ''): static
    {
        return $this->initialized()
            ->setSuccess(true)
            ->withMessage($message)
            ->withStatus('success')
            ->withCode(200);
    }

    public function failure(string $message = ''): static
    {
        return $this->initialized()
            ->setSuccess(false)
            ->withMessage($message)
            ->withCode(0)
            ->withStatus('failed')
            ->withErrors(['messages' => [$message]]);
    }

    public function isInitialized(): bool
    {
        return $this->initial;
    }

    public function passes(): bool
    {
        return $this->isInitialized() && !$this->hasErrors() && $this->success;
    }

    public function fails(): bool
    {
        return $this->isInitialized() && !$this->success;
    }

    public function setSuccess(bool $success): static
    {
        $this->success = $success;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function withMessage(string $message): static
    {
        $this->message = Sanitizer::sanitize($message, 'message');
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function withStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function withCode(int $code): static
    {
        $this->code = $code ?? 0;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function withType(string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function payload(): ?Collection
    {
        return $this->payload;
    }

    public function withPayload(Collection|array|null $payload): static
    {
        if ($this->fails()) {
            $this->payload = null;
            return $this;
        }

        if (is_a($payload, Collection::class)) {
            $payload = $payload?->toArray() ?? null;
        }

        $this->payload = new Collection($payload ?? []);
        return $this;
    }

    public function getErrors(string $key = ''): MessageBag|Collection|null
    {
        if (!empty($key)) {
            return $this->errors?->get($key);
        }

        return $this->errors;
    }

    public function withErrors(MessageBag|Collection|array $errors): static
    {
        if ($this->passes()) {
            return $this;
        }

        if ($this->isInitialized()) {
            if (!is_array($errors)) {
                $errors = $errors?->toArray();
            }

            $this->addErrors($errors);
            return $this;
        }

        if (is_array($errors)) {
            $errors = new Collection($errors);
        }

        $this->errors = $errors;

        return $this;
    }

    public function addErrors(array $errors): static
    {
        if ($this->passes()) {
            return $this;
        }

        if (!empty($errors)) {
            $this->errors?->merge($errors);
        }

        return $this;
    }

    public function clearErrors(): static
    {
        $this->errors = null;
        return $this;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function operator(?object $operator): static
    {
        if (is_a($operator, LogicResponse::class)) {
            $operator = null;
        }

        $this->operator = $this->passes() ? $operator : null;
        return $this;
    }

    public function then(): mixed
    {
        return $this->operator ?? $this;
    }

    public function isEmpty(): bool
    {
        return empty($this->payload?->toArray() ?? null);
    }

    public function toArray(): array
    {
        $array = Helper::filter(array_merge([
            'success' => $this->passes(),
            'message' => $this->getMessage(),
        ], $this->formatResponProps()));

        return $this->isInitialized() ? $array : [];
    }

    public function debug(): static
    {
        $this->storeLog('debug');
        return $this;
    }

    public function storeActivity(): static
    {
        if (!$this->isInitialized() || $this->fails()) {
            return $this->failure('Failed to store activity log: Undefined response.');
        }

        Activity::withProperties($this->formatResponProps())->event($this->status ?? $this->type ?? 'response')->log($this->message);

        return $this;
    }

    public function storeLog(string $level = ''): static
    {
        if (!$this->isInitialized()) {
            return $this->failure('Failed to store system log: Undefined response.');
        }

        $level = Sanitizer::sanitize($level, 'filter', $this->allowedLevel);
        $context = $this->formatResponProps();

        if (empty($level)) {
            $level = $this->passes() ? 'info' : 'error';
        }

        Log::log($level, $this->message, $context);

        return $this;
    }

    protected function formatResponProps(): array
    {
        return Helper::filter([
            'status' => $this->status,
            'code' => $this->code,
            'type' => $this->type,
            'payload' => Sanitizer::sanitize($this->payload?->toArray(), 'sensitive'),
            'errors' => Sanitizer::sanitize($this->errors?->toArray(), 'sensitive'),
            'requests' => [
                'ip' => request()->ip(),
                'method' => request()->method(),
                'route' => request()->route() ? request()->route()->getName() : '',
                'url' => request()->fullUrl(),
                'userAgent' => request()->userAgent(),
                'userId' => auth()->id() ?? '',
            ],
            'operator' => is_object($this->operator) ? get_class($this->operator) : null,
            'timestamp' => now()->toDateTimeString()
        ]);
    }

    protected function initialized(): static
    {
        $this->initial = true;
        return $this;
    }
}
