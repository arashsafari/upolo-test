<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Repositories\ContactRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreContactRequest;
use App\Http\Requests\Api\V1\UpdateContactRequest;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{

    public function __construct(public ContactRepositoryInterface $contactRepository)
    {
    }

    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $contacts = $this->contactRepository->all();

        return apiResponse()
            ->message('contacts list')
            ->data(new ContactCollection($contacts))
            ->send();
    }

    /**
     * store
     *
     * @param StoreContactRequest $request
     * @return JsonResponse
     */
    public function store(StoreContactRequest $request): JsonResponse
    {
        $contact = $this->contactRepository->create($request->validated());

        return apiResponse()
            ->message('contact created successfully')
            ->data(new ContactResource($contact))
            ->send();
    }

    /**
     * show
     *
     * @param Contact $contact
     * @return JsonResponse
     */
    public function show(Contact $contact): JsonResponse
    {
        return apiResponse()
            ->message('contact info')
            ->data(new ContactResource($contact))
            ->send();
    }

    /**
     * update
     *
     * @param Contact $contact
     * @param UpdateContactRequest $request
     * @return JsonResponse
     */
    public function update(UpdateContactRequest $request, Contact $contact): JsonResponse
    {
        $contact = $this->contactRepository->update($request->validated(), $contact->id);

        return apiResponse()
            ->message('contact updated successfully')
            ->data(new ContactResource($contact))
            ->send();
    }
}
