<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;

class Entity
{
    protected ?Model $model = null;

    protected string $modelName = '';

    public static function make(?Model $model = null): static
    {
        return (new static())->fill($model);
    }

    public function fill(?Model $model): static
    {
        $this->model = $model;
        $this->modelName = class_basename($model ?? '');

        return $this;
    }

    public function instance(): ?Model
    {
        return $this->model;
    }

    public function query(): ?Model
    {
        return $this->model?->newQuery();
    }
}
