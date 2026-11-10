<?php

namespace App\Repositories\AdNotes;

use App\Models\AdNote;

interface AdNotesRepositoryInterface
{
    /**
     * Creates a note.
     */
    public function create(array $data);

    /**
     * Find a note by id.
     *
     * @param  int  $id
     * @return AdNote
     */
    public function find($id);
}
