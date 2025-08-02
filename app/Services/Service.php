<?php

namespace App\Services;

use App\Helpers\LogicResponse;
use Illuminate\Database\Eloquent\Model;

class Service
{
    protected ?Model $model = null;

    public function __construct(?Model $model = null)
    {
        $this->fill($model);
    }


    public function response(): LogicResponse
    {
        return LogicResponse::make()
            ->with('type', $this)
            ->with('payload', $this->toArray());
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
