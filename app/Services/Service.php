<?php

namespace App\Services;

use App\Helpers\Attribute;
use App\Helpers\Debugger;
use App\Helpers\Helper;
use App\Helpers\ModelWrapper;
use App\Helpers\LogicResponse;
use App\Helpers\Sanitizer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class Service
{
    protected ?Attribute $attributes = null;

    protected ?Model $model = null;

    protected string $type = 'Service';

    protected array $permissions = [];

    public function __construct(?Model $model = null, array $permissions = [])
    {
        $this->model = $model ?? null;
        $this->type = class_basename($model ?? '');
        $this->permissions = $permissions;

        $this->setAttributes();
    }

    public function __toString(): string
    {
        return Helper::stringify(Helper::objectToArray($this));
    }

    public function response(): LogicResponse
    {
        $response = new LogicResponse();
        return $response->withType($this->type ?? '');
    }

    protected function model(): ?ModelWrapper
    {
        if (empty($this->model)) {
            throw new \Exception("There is no model declared in this service class.");
        }

        return new ModelWrapper($this->model, $this->permissions);
    }

    protected function setAttributes(array $values = []): static
    {
        $this->attributes = Attribute::make($values, $this->defaultAttributes());
        return $this;
    }

    protected function defaultAttributes(): array
    {
        if (empty($this->model)) {
            return [];
        }

        return $this->model()->attributes()?->toArray() ?? [];
    }

    public function getAttributes(): ?Attribute
    {
        $attributes = Sanitizer::sanitize($this->attributes?->toArray() ?? [], 'sensitive');
        return Attribute::make($attributes);
    }

    public function validate(array $data, ?array $rules = [], array $messages = [], array $attributes = []): LogicResponse
    {
        if (empty($rules)) {
            return $this->response()->success('There are no rules being validated.')
                ->withPayload($data);
        }

        $validator = Validator::make($data, $rules, $messages, $attributes);

        if ($validator->fails()) {
            $exception = new ValidationException($validator);
            Debugger::debug($exception, 'Validation failed');

            return $this->response()->failure('Validation failed: ' . $validator->errors()->first())
                ->withErrors($validator->errors()?->toArray() ?? [])
                ->storeLog();
        }

        return $this->response()->success("Data is validated successfully.")
            ->withPayload($validator->validate())
            ->operator($this);
    }
}
