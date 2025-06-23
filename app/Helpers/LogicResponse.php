<?php

namespace App\Helpers;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Log;
use App\Contracts\LogicResponseContract;
use Spatie\Activitylog\Facades\Activity;
use Illuminate\Database\Eloquent\Collection;

/**
 * LogicResponse is a helper for standardized service responses, error handling, and logging.
 */
class LogicResponse extends Helper implements LogicResponseContract
{
    /**
     * Indicates if the response has been initialized.
     *
     * @var bool
     */
    protected bool $initial = false;

    /**
     * Indicates if the response is successful.
     *
     * @var bool
     */
    protected bool $success = true;

    /**
     * The response message structure.
     *
     * @var array
     */
    protected array $message = [
        'message' => '',
        'replace' => [],
        'locale' => 'en',
        'translated' => '',
    ];

    /**
     * The response status.
     *
     * @var string
     */
    protected string $status = '';

    /**
     * The response code.
     *
     * @var int
     */
    protected int $code = 0;

    /**
     * The response type.
     *
     * @var string
     */
    protected string $type = '';

    /**
     * The response payload.
     *
     * @var Collection|null
     */
    protected ?Collection $payload = null;

    /**
     * The operator object (usually the service or model).
     *
     * @var object|null
     */
    protected ?object $operator = null;

    /**
     * The response errors.
     *
     * @var MessageBag|null
     */
    protected ?MessageBag $errors = null;

    /**
     * Allowed log levels.
     *
     * @var array
     */
    protected array $allowedLevel = [
        'info', 'debug', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'
    ];

    /**
     * Static factory for creating a LogicResponse instance.
     *
     * @param bool $success
     * @param string $message
     * @param string $status
     * @param int $code
     * @param string $type
     * @param array $payload
     * @return static
     */
    public static function make(
        bool $success = true,
        string $message = '',
        string $status = '',
        int $code = 0,
        string $type = '',
        array $payload = []
    ): static {
        $instance = new static();
        $response = $success ? $instance->success($message) : $instance->failure($message);

        return $response
            ->withStatus($status)
            ->withCode($code)
            ->withType($type)
            ->withPayload($payload);
    }

    /**
     * Mark the response as initialized.
     *
     * @return static
     */
    protected function initialized(): static
    {
        $this->initial = true;
        return $this;
    }

    /**
     * Check if the response is initialized.
     *
     * @return bool
     */
    protected function isInitialized(): bool
    {
        return $this->initial;
    }

    /**
     * Mark the response as successful.
     *
     * @param string $message
     * @param array $replace
     * @param string $locale
     * @return static
     */
    public function success(string $message = '', array $replace = [], string $locale = 'en'): static
    {
        return $this->initialized()
            ->setSuccess(true)
            ->withMessage($message, $replace, $locale)
            ->withStatus('success')
            ->withCode(200)
            ->clearErrors();
    }

    /**
     * Mark the response as failed.
     *
     * @param string $message
     * @param array $replace
     * @param string $locale
     * @return static
     */
    public function failure(string $message = '', array $replace = [], string $locale = 'en'): static
    {
        return $this->initialized()
            ->setSuccess(false)
            ->withMessage($message, $replace, $locale)
            ->withCode(0)
            ->withStatus('failed')
            ->withErrors(['messages' => [$this->getMessage()]]);
    }

    /**
     * Set the success flag.
     *
     * @param bool $success
     * @return static
     */
    public function setSuccess(bool $success): static
    {
        $this->success = $success;
        return $this;
    }

    /**
     * Get the response status.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Set the response status.
     *
     * @param string $status
     * @return static
     */
    public function withStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get the response code.
     *
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * Set the response code.
     *
     * @param int $code
     * @return static
     */
    public function withCode(int $code): static
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Get the response type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set the response type.
     *
     * @param string|object $type
     * @return static
     */
    public function withType(string|object $type): static
    {
        if (is_object($type)) {
            $type = class_basename($type);
        }

        $this->type = $type;
        return $this;
    }

    /**
     * Get the translated response message.
     *
     * @return string
     */
    public function getMessage(string $locale = ''): string
    {
        if (empty($locale)) {
            return $this->message['translated'] ?? '';
        }

        return $this->transMessage(
            $this->message['message'] ?? '',
            $this->message['replace'] ?? [],
            $locale
        );
    }

    /**
     * Set the response message.
     *
     * @param string $message
     * @param array $replace
     * @param string $locale
     * @return static
     */
    public function withMessage(string $message, array $replace = [], string $locale = 'en'): static
    {
        $message = Sanitizer::sanitize($message, 'message');
        $this->message = [
            'message' => $message,
            'replace' => $replace,
            'locale' => $locale,
            'translated' => $this->transMessage($message, $replace, $locale)
        ];
        return $this;
    }

    /**
     * Translate a message with replacements and locale.
     *
     * @param string $message
     * @param array $replace
     * @param string $locale
     * @return string
     */
    protected function transMessage(string $message, array $replace = [], string $locale = 'en'): string
    {
        return Translator::translate($message, $replace, $locale);
    }

    /**
     * Get the response payload.
     *
     * @return Collection|null
     */
    public function payload(): ?Collection
    {
        if ($this->fails()) {
            $this->payload = null;
        }
        return $this->payload;
    }

    /**
     * Set the response payload.
     *
     * @param Collection|array|null $payload
     * @return static
     */
    public function withPayload(Collection|array|null $payload): static
    {
        if ($payload instanceof Collection) {
            $payload = $payload->toArray();
        }
        $this->payload = new Collection($payload ?? []);
        return $this;
    }

    /**
     * Get the response errors.
     *
     * @param string $key
     * @return MessageBag|array|null
     */
    public function getErrors(string $key = ''): MessageBag|array|null
    {
        if ($this->errors === null) {
            return null;
        }
        if ($key) {
            return $this->errors->get($key);
        }
        return $this->errors;
    }

    /**
     * Set the response errors.
     *
     * @param array|MessageBag|null $errors
     * @return static
     */
    public function withErrors(array|MessageBag|null $errors): static
    {
        if ($this->passes()) {
            return $this;
        }
        if ($errors instanceof MessageBag) {
            $this->errors = $errors;
        } elseif (is_array($errors)) {
            $this->errors = new MessageBag($errors);
        } else {
            $this->errors = null;
        }
        return $this;
    }

    /**
     * Add an error to the response.
     *
     * @param string $key
     * @param string $message
     * @return static
     */
    public function addErrors(string $key, string $message): static
    {
        if ($this->passes()) {
            return $this;
        }
        if (!$this->errors) {
            $this->errors = new MessageBag();
        }
        $this->errors->add($key, $message);
        return $this;
    }

    /**
     * Clear all errors from the response.
     *
     * @return static
     */
    public function clearErrors(): static
    {
        $this->errors = null;
        return $this;
    }

    /**
     * Check if the response has errors.
     *
     * @return bool
     */
    public function hasErrors(): bool
    {
        return $this->errors instanceof MessageBag && $this->errors->isNotEmpty();
    }

    /**
     * Set the operator object.
     *
     * @param object|null $operator
     * @return static
     */
    public function operator(?object $operator): static
    {
        if ($operator instanceof LogicResponse) {
            $operator = null;
        }
        $this->operator = $this->passes() ? $operator : null;
        return $this;
    }

    /**
     * Return the operator or self if passes, otherwise return self.
     *
     * @return mixed
     */
    public function then(): mixed
    {
        if ($this->fails()) {
            return $this;
        }
        return $this->operator ?? $this;
    }

    /**
     * Check if the response passes.
     *
     * @return bool
     */
    public function passes(): bool
    {
        return $this->isInitialized() && !$this->hasErrors() && $this->success;
    }

    /**
     * Check if the response fails.
     *
     * @return bool
     */
    public function fails(): bool
    {
        return $this->isInitialized() && !$this->success;
    }

    /**
     * Check if the payload is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->payload?->toArray() ?? null);
    }

    /**
     * Convert the response to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = Helper::filter(array_merge([
            'success' => $this->passes(),
            'message' => $this->getMessage(),
        ], $this->formatResponProps()));

        return $this->isInitialized() ? $array : [];
    }

    /**
     * Debug the response and log exception if fails.
     *
     * @param \Throwable|null $exception
     * @param array $property
     * @param bool $throw
     * @return static
     */
    public function debug(?\Throwable $exception = null, array $property = [], bool $throw = false): static
    {
        if ($this->fails()) {
            $exception ??= new \LogicException($this->getMessage() ?: 'LogicResponse failed.');
            Debugger::debug($exception, 'LogicResponse failed.', $this->toArray(), $property, $throw);
        }
        return $this;
    }

    /**
     * Store activity log if response passes.
     *
     * @return static
     */
    public function storeActivity(): static
    {
        if (!$this->isInitialized() || $this->fails()) {
            return $this->failure('Failed to store activity log: Undefined response.');
        }
        Activity::withProperties($this->formatResponProps())
            ->event($this->status ?: $this->type ?: 'response')
            ->log($this->getMessage());
        return $this;
    }

    /**
     * Store system log with the given level.
     *
     * @param string $level
     * @return static
     */
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
        Log::log($level, $this->getMessage(), $context);
        return $this;
    }

    /**
     * Format response properties for logging and activity.
     *
     * @return array
     */
    protected function formatResponProps(): array
    {
        return Helper::filter([
            'status' => $this->getStatus(),
            'code' => $this->getCode(),
            'type' => $this->getType(),
            'payload' => Sanitizer::sanitize($this->payload()?->toArray(), 'sensitive'),
            'errors' => Sanitizer::sanitize($this->getErrors() instanceof MessageBag ? $this->getErrors()->toArray() : [], 'sensitive'),
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
}
