<?php

namespace App\Contracts\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function all(array $where = [], array $columns = ['*'], array $relations = []): Collection;

    public function create(array $attributes): Model;

    public function find(int $id, array $columns = ['*'], bool $withTrashed = false): ?Model;

    public function findBy(string $field, mixed $value, array $columns = ['*']): ?Model;

    public function paginate(int $perPage = 15, array $columns = ['*'], array $where = [], array $orWhere = [], array $orderBy = [] , bool $withTrashed = false): LengthAwarePaginator;

    public function update(array $attributes, int $id, bool $withTrashed = false): Model;
}
