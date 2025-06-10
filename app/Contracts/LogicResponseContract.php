<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\MessageBag;

interface LogicResponseContract
{
    // --- Static Factory ---
    public static function response(
        bool $success,
        string $message = '',
        string $status = '',
        int $code = 0,
        string $type = '',
        array $payload = []
    ): static;

    // --- Initialization ---
    public function isInitialized(): bool;

    // --- Success & Failure ---
    public function success(string $message = ''): static;
    public function failure(string $message = ''): static;
    public function setSuccess(bool $success): static;

    // --- Status & Code & Type ---
    public function getStatus(): string;
    public function withStatus(string $status): static;
    public function getCode(): int;
    public function withCode(int $code): static;
    public function getType(): string;
    public function withType(string $type): static;

    // --- Message ---
    public function getMessage(): string;
    public function withMessage(string $message): static;

    // --- Payload ---
    public function payload(): ?Collection;
    public function withPayload(Collection|array|null $payload): static;

    // --- Errors ---
    public function getErrors(string $key = ''): MessageBag|Collection|null;
    public function withErrors(MessageBag|Collection|array $errors): static;
    public function addErrors(array $errors): static;
    public function clearErrors(): static;
    public function hasErrors(): bool;

    // --- Operator & Then ---
    public function operator(?object $operator): static;
    public function then(): mixed;

    // --- Pass/Fail/Empty ---
    public function passes(): bool;
    public function fails(): bool;
    public function isEmpty(): bool;

    // --- Array & Debug & Log ---
    public function toArray(): array;
    public function debug(array $property = [], bool $throw = false): static;
    public function storeActivity(): static;
    public function storeLog(string $level = ''): static;
}
