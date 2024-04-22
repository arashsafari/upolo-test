<?php

namespace App\Repositories;

use App\Contracts\Repositories\BaseRepositoryInterface;

use App\Exceptions\BadRequestException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    /**
     * @throws BadRequestException
     */
    public function __construct(public Application $app)
    {
        $this->makeModel();
    }

    abstract protected function model();

    /**
     * @throws BadRequestException
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new BadRequestException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * all
     *
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $where = [], array $columns = ['*'], array $relations = []): Collection
    {
        $query = $this->model->newQuery();

        if (!empty($relations)) {
            $query = $query->with($relations);
        }

        foreach ($where as $field => $value) {
            $query = $query->where($field, $value);
        }

        return $query->get($columns);
    }

    /**
     * create
     *
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * find
     *
     * @param int $id
     * @param array|string[] $columns
     * @param bool $withTrashed
     * @return Model|null
     */
    public function find(int $id, array $columns = ['*'], bool $withTrashed = false): ?Model
    {
        if ($withTrashed) {
            return $this->model->withTrashed()->where('id', $id)->first($columns);
        }

        return $this->model->find($id, $columns);
    }

    /**
     * find By
     *
     * @param string $field
     * @param mixed $value
     * @param array $columns
     * @return Model|null
     */
    public function findBy(string $field, mixed $value, array $columns = ['*']): ?Model
    {
        return $this->model->where($field, '=', $value)->first($columns);
    }

    /**
     * paginate
     *
     * @param int $perPage
     * @param array|string[] $columns
     * @param array $where
     * @param array $orWhere
     * @param array $orderBy
     * @param bool $withTrashed
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], array $where = [], array $orWhere = [], array $orderBy = [], bool $withTrashed = false): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        if ($withTrashed) {
            $query->withTrashed();
        }

        foreach ($where as $field => $value) {
            if (is_array($value)) {
                $query->where($field, $value[0], $value[1]);
                continue;
            }

            $query->where($field, $value);
        }

        $query->where(function ($query) use ($orWhere) {
            foreach ($orWhere as $field => $value) {
                if (is_array($value)) {
                    $query->orWhere($field, $value[0], $value[1]);
                    continue;
                }
                $query->orWhere($field, $value);
            }
        });

        $orderByColumn = 'created_at';
        $orderByType = 'desc';
        if ($orderBy) {
            $orderByColumn = $orderBy[0] ?? 'created_at';
            $orderByType = $orderBy[1] ?? 'desc';
        }

        return $query->orderBy($orderByColumn, $orderByType)->paginate($perPage, $columns);
    }

    /**
     * update
     *
     * @param array $attributes
     * @param int $id
     * @param bool $withTrashed
     * @return Model
     */
    public function update(array $attributes, int $id, bool $withTrashed = false): Model
    {
        $record = $this->find($id, withTrashed: $withTrashed);
        $record->update($attributes);
        return $record;
    }
}
