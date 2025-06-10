<?php

namespace App\Services;

use App\Helpers\Debugger;
use App\Helpers\Helper;
use App\Helpers\ModelWrapper;
use App\Helpers\LogicResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class Service
{
    protected ?Model $model = null;

    protected array $permissions = [];

    protected string $type = 'Service';

    public function __construct(?Model $model = null, array $permissions = [], ?string $type = null)
    {
        $this->model = $model;
        $this->permissions = $permissions;
        $this->type ??= $type ?? static::class;
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

    public function model(): ?ModelWrapper
    {
        if (empty($this->model)) {
            Debugger::debug(new \LogicException("There is no model declared in this service class."))->throw();

            return null;
        }

        return new ModelWrapper($this->model, $this->permissions);
    }

    public function validate(array $data, ?array $rules = [], array $messages = [], array $attributes = []): LogicResponse
    {
        if (method_exists($this, 'rules')) {
            $rules = array_merge($this->rules(), $rules);
        }

        if (empty($rules)) {
            return $this->response()->success('There are no rules being validated.')
                ->withPayload($data)
                ->operator($this);
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
