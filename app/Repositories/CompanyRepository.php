<?php

namespace App\Repositories;

use App\Contracts\Repositories\CompanyRepositoryInterface;
use App\Models\Company;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class CompanyRepository extends BaseRepository implements CompanyRepositoryInterface
{
    protected function model(): string
    {
        return Company::class;
    }

    /**
     * search
     *
     * @param int $perPage
     * @param array $query
     * @return LengthAwarePaginator
     */
    public function search(int $perPage = 15, array $query = []): LengthAwarePaginator
    {
        $dbQuery = $this->model->newQuery();

        $query = collect($query);

        $dbQuery->when($query->get('name'), function (Builder $builder) use ($query) {
            $builder->where(function ($builder) use ($query) {
                $name = $query->get('name');
                $builder->orWhere('name', 'LIKE', "%$name%");
                $builder->orWhereHas('contacts', function ($q) use ($name) {
                    $q->orWhere('first_name', 'LIKE', "%$name%");
                    $q->orWhere('last_name', 'LIKE', "%$name%");
                });
            });
        });

        return $dbQuery->paginate($perPage);
    }
}
