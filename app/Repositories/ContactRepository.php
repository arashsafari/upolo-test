<?php

namespace App\Repositories;

use App\Contracts\Repositories\ContactRepositoryInterface;
use App\Models\Contact;

class ContactRepository extends BaseRepository implements ContactRepositoryInterface
{
    protected function model(): string
    {
        return Contact::class;
    }

}
