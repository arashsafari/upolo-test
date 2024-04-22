<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Repositories\CompanyRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreCompanyRequest;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    public function __construct(public CompanyRepositoryInterface $companyRepository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $companies = $this->companyRepository->paginate(
            perPage: 10
        );

        return apiResponse()
            ->message('companies found')
            ->data(new CompanyCollection($companies))
            ->send();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request): JsonResponse
    {
        $company = $this->companyRepository->create($request->validated());

        return apiResponse()
            ->message('company create successfully')
            ->data(new CompanyResource($company))
            ->send();
    }
}
