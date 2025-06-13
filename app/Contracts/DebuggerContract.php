<?php

namespace App\Contracts;

use Throwable;
use App\Helpers\LogicResponse;

interface DebuggerContract
{
    public static function debug(
        Throwable $exception,
        string $message = '',
        array $context = [],
        array $properties = [],
        bool $throw = false
    ): static;

    public static function isDebug(): bool;

    public function response(): LogicResponse;

    public function exception(): Throwable;

    public function getMessage(): string;

    public function getContext(): array;

    public function getProperties(): array;

    public function dump(bool $die = false): void;

    public function throw(): void;

    public function throwIf(bool|callable $condition): void;

    public function throwUnless(bool|callable $condition): void;

    public function abort(?int $code = null, array $header = []): never;

    public function abortIf(bool|callable $condition, ?int $code = null, array $header = []): void;

    public function abortUnless(bool|callable $condition, ?int $code = null, array $header = []): void;

    public function toArray(): array;
}
