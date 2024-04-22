<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Repositories\NoteRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreNoteRequest;
use App\Http\Resources\NoteResource;
use Illuminate\Http\JsonResponse;

class NoteController extends Controller
{

    public function __construct(public NoteRepositoryInterface $noteRepository)   
    {
    }

    /**
     * store
     *
     * @param StoreNoteRequest $request
     * @return JsonResponse
     */
    public function store(StoreNoteRequest $request): JsonResponse
    {
        $note = $this->noteRepository->create($request->validated());

        return apiResponse()
            ->message('note created successfully')
            ->data(new NoteResource($note))
            ->send();
    }
}
