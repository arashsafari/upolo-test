<?php

namespace App\Repositories;

use App\Contracts\Repositories\NoteRepositoryInterface;
use App\Models\Note;

class NoteRepository extends BaseRepository implements NoteRepositoryInterface
{
    protected function model(): string
    {
        return Note::class;
    }

}
