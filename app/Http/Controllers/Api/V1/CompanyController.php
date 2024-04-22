<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Repositories\CompanyRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AddContactToCompanyRequest;
use App\Http\Requests\Api\V1\StoreCompanyRequest;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\ContactCollection;
use App\Models\Company;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    public function __construct(public CompanyRepositoryInterface $companyRepository)
    {
    }

    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $companies = $this->companyRepository->paginate(
            perPage: 10
        );

        return apiResponse()
            ->message('companies list')
            ->data(new CompanyCollection($companies))
            ->send();
    }

    /**
     * store
     *
     * @param StoreCompanyRequest $request
     * @return JsonResponse
     */
    public function store(StoreCompanyRequest $request): JsonResponse
    {
        $company = $this->companyRepository->create($request->validated());

        return apiResponse()
            ->message('company created successfully')
            ->data(new CompanyResource($company))
            ->send();
    }

    /**
     * addContact
     *
     * @param Company $company
     * @param AddContactToCompanyRequest $request
     * @return JsonResponse
     */
    public function addContact(AddContactToCompanyRequest $request,Company $company): JsonResponse
    {
        $company->contacts()->sync($request->contact_id);

        return apiResponse()
            ->message('contacts add to company')
            ->send();
    }

    /**
     * contacts
     *
     * @param Company $company
     * @return JsonResponse
     */
    public function contacts(Company $company): JsonResponse
    {
        return apiResponse()
            ->message('company contacts')
            ->data(new ContactCollection($company->contacts))
            ->send();
    }
}
