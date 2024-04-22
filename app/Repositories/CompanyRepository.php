<?php

namespace App\Repositories;

use App\Contracts\Repositories\CompanyRepositoryInterface;
use App\Models\Company;

class CompanyRepository extends BaseRepository implements CompanyRepositoryInterface
{
    protected function model(): string
    {
        return Company::class;
    }

}
