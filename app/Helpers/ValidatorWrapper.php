<?php

namespace App\Helpers;

use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ValidatorWrapper extends Helper
{
    protected ValidatorContract $validator;

    protected bool $validated = false;

    public function validate(array $data, array $rules, array $messages = [], array $attributes = []): static
    {
        $this->validator = Validator::make($data, $rules, $messages, $attributes);
        $this->validated = true;

        return $this;
    }

    public function passed(): bool
    {
        return $this->validated && ! $this->validator->fails();
    }

    public function failed(): bool
    {
        return ! $this->passed();
    }

    public function errors(): array
    {
        return $this->validator->errors()->toArray();
    }

    public function firstError(?string $field = null): ?string
    {
        return $this->validator->errors()->first($field);
    }

    public function throwIfFailed(): void
    {
        if ($this->failed()) {
            throw new ValidationException($this->validator);
        }
    }

    public function valid(): array
    {
        return $this->validator->validated();
    }

    public function invalid(): array
    {
        return array_diff_key($this->validator->errors()->toArray(), $this->validator->validated());
    }

    public function validator(): ValidatorContract
    {
        return $this->validator;
    }
}
