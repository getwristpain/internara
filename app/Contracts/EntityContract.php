<?php

namespace App\Contracts;

use App\Helpers\Attribute;
use App\Helpers\LogicResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface EntityContract
{
    public function query(): Model|null;

    public function instance(): Model|Builder|null;

    public function all(array|string $column = '[*]'): Collection|null;

    public function get(array $where = [], array $with = [], array|string $column = '[*]'): Collection|null;

    public function find($id, array $with = []): Collection|Model|null;

    public function first(array $where = [], array $with = []): Model|null;

    public function firstOrFail(array $where = [], array $with = []): Model|null;

    public function firstOrCreate(array $where = [], array $attributes = [], array $with = []): Model|null;

    public function create(array $attributes = []): LogicResponse;

    public function insert(array $rows): LogicResponse;

    public function update(array $attributes = [], array $where = []): LogicResponse;

    public function delete($id): LogicResponse;

    public function destroy(array $ids): LogicResponse;

    public function toArray(): array;

    public function toAttributes(): Attribute|null;

    public function toCollection(): Collection|null;

    public function response(): LogicResponse;
}
