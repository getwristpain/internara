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

    protected string $type = 'Service';


    public function __construct(?Model $model = null, ?string $type = null)
    {
        $this->setModel($model);
        $this->setType($type);
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

    public function model(): ?ModelWrapper
    {
        if (empty($this->model)) {
            Debugger::debug(new \LogicException("There is no model declared in this service class."));

            return ModelWrapper::make();
        }

        return ModelWrapper::make($this->model);
    }

    protected function setModel(?Model $model = null): static
    {
        $this->model = $model;
        return $this;
    }

    protected function setType(?string $type = ''): static
    {
        $this->type = empty($type) ? (empty($this->model) ? class_basename($this) : class_basename($this->model)) : $type;
        return $this;
    }
}
