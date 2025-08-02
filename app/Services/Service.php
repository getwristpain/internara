<?php

namespace App\Services;

use App\Helpers\Entity;
use App\Helpers\LogicResponse;
use Illuminate\Database\Eloquent\Model;

class Service
{
    protected ?Model $model = null;

    /**
     * Class constructor.
     */
    public function __construct(?Model $model = null)
    {
        $this->fill($model);
    }

    public function model(): Entity
    {
        return Entity::make($this->model);
    }

    public function response(): LogicResponse
    {
        return LogicResponse::make()
            ->with('type', $this)
            ->withPayload($this->toArray());
    }

    public function toArray(): array
    {
        return [
            'data' => $this->model?->toArray() ?? []
        ];
    }

    protected function fill(?Model $model): static
    {
        $this->model = $model;

        return $this;
    }
}
