<?php

namespace App\Contracts;

use App\Helpers\Attribute;
use App\Helpers\LogicResponse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface EntityContract
{
    public static function make(Model $model, array $permissions = [], array $defaultData = []): static;
    public function query(): ?Model;
    public function with(array $relations = []): static;
    public function withTrashed(): static;
    public function onlyTrashed(): static;
    public function isPermitted(string|array $permission = ''): bool;
    public function isNotPermitted(string|array $permission = ''): bool;
    public function count(): int;
    public function toCollection(): Collection;
    public function toAttributes(): Attribute;
    public function toArray(): array;
    public function toJson(int $options = 0): string;
    public function response(): LogicResponse;
    public function find(string|int $id): ?Attribute;
    public function first(array $where = []): ?Attribute;
    public function firstOrFail(array $where = []): ?Attribute;
    public function firstOrCreate(array $attributes = [], array $values = []): ?Attribute;
    public function search(callable $conditions): ?Collection;
    public function get(array $where = []): Attribute|Collection|null;
    public function set(string|array $key, mixed $value = ''): LogicResponse;
    public function create(array $attributes = []): LogicResponse;
    public function insert(array $data = []): LogicResponse;
    public function update(array $where = [], array $attributes = []): LogicResponse;
    public function updateById(string|int $id, array $attributes = []): LogicResponse;
    public function updateOrCreate(array $where = [], array $attributes = []): LogicResponse;
    public function delete(array $where = []): LogicResponse;
    public function deleteByIds(string|int|array $ids): LogicResponse;
    public function batchDelete(string $whereIn, array $values = []): LogicResponse;
    public function forceDelete(): LogicResponse;
    public function restore(): LogicResponse;
    public function paginate(callable $callback, int $perPage = 15, array $columns = ['*']): Collection;
    public function transaction(?callable $callback, int $attempts = 1): mixed;
    public function setModel(Model|Builder|null $model = null, array $with = []): static;
    public function setPermissions(array $permissions = []): static;
    public function setData(Model|Collection|Attribute|array $data = []): static;
}
