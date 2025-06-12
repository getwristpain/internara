<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * @template TModel of Model
 */
class ModelWrapper extends Helper
{
    protected ?Model $model;

    protected ?string $modelClass = null;

    protected string $type = 'Record';

    protected array $data = [];

    protected array $meta = [];

    /**
     * @param Model|null $model
     * @param array $permissions
     * @param array $defaultData
     * @param array $relations
     */
    public static function make(?Model $model = null, array $meta = [], array $defaultData = []): static
    {
        $instance = new static();
        $instance->setModel($model)
            ->setData($defaultData)
            ->setMeta($meta);

        return $instance;
    }

    public function query(): ?Model
    {
        return app($this->modelClass);
    }

    public function instance(): ?Model
    {
        return $this->model;
    }

    public function data(): array
    {
        return $this->data;
    }

    public function meta(): array
    {
        return $this->meta;
    }

    public function get(string|int|array $key, mixed $default = null): mixed
    {
        if (empty($this->data)) {
            return [];
        }

        return ArrayHelper::get($this->data, $key, $default);
    }

    public function set(string|int|array $key, mixed $value): static
    {
        if (empty($this->data)) {
            return $this;
        }

        ArrayHelper::set($this->data, $key, $value);

        if (ArrayHelper::isFlatAssoc($this->data) && !empty($this->model->toArray())) {
            $this->model->update($this->filterFillable($this->data));
        }

        return $this;
    }

    public function toAttributes(): Attribute
    {
        return Attribute::make($this->data);
    }

    public function toCollection(): Collection
    {
        if (!ArrayHelper::isFlatAssoc($this->data)) {
            return Collection::make([$this->data]);
        }

        return Collection::make($this->data);
    }

    public function response(): LogicResponse
    {
        $response = new LogicResponse();
        return $response
            ->withType($this->type)
            ->withPayload([
                    'data' => $this->data,
                    'meta' => $this->meta
                ]);
    }

    protected function setmodel(?Model $model): static
    {
        $this->model = $model;
        $this->modelClass = $model ? get_class($model) : null;
        $this->type = $model ? class_basename($model) : $this->type;

        return $this;
    }

    protected function setData(array $default = []): static
    {
        $modelData = $this->model?->toArray();
        $this->data = empty($modelData) ? $default : $modelData;
        return $this;
    }

    public function setMeta(array $meta = []): static
    {
        $this->meta = $meta;
        return $this;
    }

    public function filterFillable(array $attributes): array
    {
        return Helper::filter($attributes, $this->model->getFillable());
    }
}
