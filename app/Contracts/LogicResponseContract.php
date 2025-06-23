<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\MessageBag;

interface LogicResponseContract
{
    public static function make(
        bool $success,
        string $message = '',
        string $status = '',
        int $code = 0,
        string $type = '',
        array $payload = []
    ): static;

    public function success(string $message = '', array $replace = [], string $locale = ''): static;

    public function failure(string $message = '', array $replace = [], string $locale = ''): static;

    public function setSuccess(bool $success): static;

    public function getStatus(): string;

    public function withStatus(string $status): static;

    public function getCode(): int;

    public function withCode(int $code): static;

    public function getType(): string;

    public function withType(string $type): static;

    public function getMessage(string $locale = ''): string;

    public function withMessage(string $message, array $replace = [], string $locale = 'en'): static;

    public function payload(): ?Collection;

    public function withPayload(Collection|array|null $payload): static;

    public function getErrors(string $key = ''): MessageBag|array|null;

    public function withErrors(array|MessageBag|null $errors): static;

    public function addErrors(string $key, string $message): static;

    public function clearErrors(): static;

    public function hasErrors(): bool;

    public function operator(?object $operator): static;

    public function then(): mixed;

    public function passes(): bool;

    public function fails(): bool;

    public function isEmpty(): bool;

    public function toArray(): array;

    public function debug(?\Throwable $exception = null, array $property = [], bool $throw = false): static;

    public function storeActivity(): static;

    public function storeLog(string $level = ''): static;
}
