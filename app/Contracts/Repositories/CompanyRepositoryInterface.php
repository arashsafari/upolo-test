<?php

namespace App\Contracts\Repositories;

use App\Contracts\Repositories\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CompanyRepositoryInterface extends BaseRepositoryInterface
{
    public function search(int $perPage = 15, array $query = []): LengthAwarePaginator;
}
