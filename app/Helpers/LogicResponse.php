<?php

namespace App\Helpers;

use App\Helpers\Helper;
use App\Helpers\Sanitizer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Activitylog\Facades\Activity;

class LogicResponse extends Helper
{
    private array $allowedLevel = ['info', 'debug', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'];

    protected bool $success = false;

    protected string $message = '';

    protected int $code = 0;

    protected string $status = '';

    protected string $type = '';

    protected ?Collection $data = null;

    protected ?array $meta = null;

    protected ?Collection $errors = null;

    public static function success(string $message = '', ?Collection $data = null, ?array $meta = null, int $code = 200, string $status = 'success', string $type = ''): LogicResponse
    {
        return (new static())
            ->setSuccess(true)
            ->setMessage($message)
            ->setCode($code)
            ->setStatus($status)
            ->setType($type)
            ->setData($data)
            ->setMeta($meta);
    }

    public static function fail(string $message = '', ?Collection $data = null, ?array $meta = null, int $code = 200, string $status = 'success', string $type = ''): LogicResponse
    {
        return (new static())
            ->setSuccess(false)
            ->setMessage($message)
            ->setCode($code)
            ->setStatus($status)
            ->setType($type)
            ->setData($data)
            ->setMeta($meta)
            ->setErrors(['errors' => [$message]]);
    }

    public function setSuccess(bool $success): static
    {
        $this->success = $success;
        return $this;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = Sanitizer::sanitize($message, 'message');
        return $this;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): static
    {
        $this->code = $code;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getData(): Collection
    {
        return $this->data;
    }

    public function setData(Collection|array|null $data): static
    {
        if ($data instanceof Collection) {
            $data = $data->toArray();
        }

        $this->data = new Collection(Sanitizer::sanitize($data, 'sensitive'));
        return $this;
    }

    public function setMeta(?array $meta): static
    {
        $this->meta = Sanitizer::sanitize($meta, 'sensitive');
        return $this;
    }

    public function setErrors(array $errors): static
    {
        $this->errors = new Collection($errors);
        return $this;
    }

    public function toArray(): array
    {
        try {
            $array = Helper::filter(array_merge([
            'success' => $this->success,
            'message' => $this->message,
        ], $this->formatResponProps()));

            return $array ?? [];
        } catch (\Throwable $th) {
            Debugger::debug($th);
            return [];
        }
    }

    public function storeLog(string $level = 'info'): static
    {
        $level = Sanitizer::sanitize($level, 'filter', $this->allowedLevel);
        $context = $this->formatResponProps();

        Log::log($level, $this->message, $context);

        return $this;
    }

    public function storeActivity(string|int|Model|null $causedby = null): static
    {
        Activity::causedby($causedby)
            ->event($this->type)
            ->withProperties($this->formatResponProps())
            ->log($this->message);

        return $this;
    }

    public function storeSession(): static
    {
        session()->put('response', $this->toArray());

        return $this;
    }

    public function hasErrors(): bool
    {
        return $this->errors->notEmpty();
    }

    protected function formatResponProps(): array
    {
        return Helper::filter([
            'code' => $this->code,
            'status' => $this->status,
            'type' => $this->type,
            'data' => $this->data?->toArray(),
            'meta' => $this->meta,
            'errors' => $this->errors?->toArray(),
            'timestamp' => now()->toDateTimeString()
        ]);
    }
}
