<?php

namespace App\Services;

use App\Helpers\Support;
use App\Helpers\Debugger;
use App\Helpers\ModelWrapper;
use App\Helpers\LogicResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Abstract base service class for handling Eloquent models and business logic.
 */
abstract class Service
{
    /**
     * Registered service classes.
     *
     * @var array<Service|null>
     */
    protected array $services = [];

    /**
     * Eloquent model instance.
     */
    protected ?Model $model = null;

    /**
     * Service type name (used in LogicResponse).
     */
    protected string $type = 'Service';

    /**
     * Validated and processed data payload.
     */
    protected array $data = [];

    /**
     * Additional metadata for logic processing.
     */
    protected array $meta = [];

    /**
     * Create a new service instance.
     */
    public function __construct(?Model $model = null, ?string $type = null)
    {
        $this->setModel($model);
        $this->setType($type);
    }

    /**
     * Magic getter to access resolved services.
     *
     * @param string $key
     * @return Service|null
     */
    public function __get(string $key): Service|null
    {
        if (!isset($this->services[$key])) {
            Debugger::handle(
                exception: "Service '$key' is not registered. Make sure to call useServices() first.",
                throw: true,
                log: true,
            );

            return null;
        }

        return $this->services[$key] ?? null;
    }

    /**
     * Convert service instance to string.
     */
    public function __toString(): string
    {
        return Support::stringify(Support::objectToArray($this));
    }

    /**
     * Get the wrapped model instance.
     */
    public function model(): ModelWrapper
    {
        if (!$this->model) {
            Debugger::handle(new \LogicException('No model declared in service.'));
            return ModelWrapper::make();
        }

        return ModelWrapper::make($this->model);
    }

    /**
     * Get a LogicResponse initialized with this service.
     */
    public function response(): LogicResponse
    {
        return (new LogicResponse())
            ->withType($this->type)
            ->withPayload($this->toArray());
    }

    /**
     * Validate data using Laravel Validator and return response.
     */
    public function validate(
        array $data = [],
        ?array $rules = [],
        array $messages = [],
        array $attributes = []
    ): LogicResponse {
        $data = $data ?: $this->data;
        $locale = app()->getLocale();
        app()->setLocale('en');

        try {
            if (empty($rules)) {
                return $this->withData($data)
                    ->withMeta(['validated' => true])
                    ->response()
                    ->success('Tidak ada aturan validasi yang didefinisikan.')
                    ->operator($this);
            }

            $validator = Validator::make($data, $rules, $messages, $attributes);

            if ($validator->fails()) {
                Debugger::handle(new ValidationException($validator));

                return $this->response()
                    ->failure('Validasi gagal: ' . $validator->errors()->first())
                    ->withErrors($validator->errors()?->toArray() ?? [])
                    ->storeLog();
            }

            return $this->withData($validator->validated())
                ->withMeta(['validated' => true])
                ->response()
                ->success('Validasi berhasil.')
                ->operator($this);
        } finally {
            app()->setLocale($locale);
        }
    }

    /**
     * Get data from validated payload.
     */
    public function data(string|int|array $key = '', mixed $default = null): mixed
    {
        return Support::getArray($this->data, $key, $default);
    }

    /**
     * Get metadata value.
     */
    public function meta(string|int|array $key = '', mixed $default = null): mixed
    {
        return Support::getArray($this->meta, $key, $default);
    }

    /**
     * Convert service to array representation.
     */
    public function toArray(): array
    {
        $data = $this->data;

        if (empty($data) && $this->model) {
            $data = $this->model->toArray();
        }

        return [
            'data' => $data,
            'meta' => $this->meta,
        ];
    }

    /**
     * Set validated data.
     */
    public function withData(array $data): static
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Set meta information.
     */
    public function withMeta(array $meta): static
    {
        $this->meta = $meta;
        return $this;
    }

    /**
     * Set locale.
     */
    public function withLocale(string $locale, callable $callback): mixed
    {
        $original = app()->getLocale();
        app()->setLocale($locale);

        try {
            return $callback();
        } finally {
            app()->setLocale($original);
        }
    }

    /**
     * Register and resolve one or more services.
     *
     * @param Service|string|array<Service|string> $services
     * @return void
     */
    protected function useServices(Service|string|array $services): void
    {
        // Reset services
        $this->services = [];
        $services = !is_array($services) ? [$services] : $services;

        foreach ($services as $service) {
            $instance = $service instanceof self ? $service : app($service);

            $key = str(class_basename($instance))
                ->replaceLast('Service', '')
                ->lcfirst()
                ->append('Service')
                ->toString();

            $this->services[$key] = $instance;
        }
    }

    /**
     * Assign the model instance.
     */
    protected function setModel(?Model $model = null): static
    {
        $this->model = $model;
        return $this;
    }

    /**
     * Define the service type string.
     */
    protected function setType(?string $type = ''): static
    {
        $this->type = $type ?? class_basename($this);
        return $this;
    }
}
