<?php

namespace App\Repositories\Threads;

use App\Models\Thread;

interface ThreadsRepositoryInterface
{
    /**
     * Gets message by its ID
     *
     * @param int
     */
    public function find($id);

    /**
     * Gets all message.
     *
     * @return Thread[]
     */
    public function all($paginate = null);

    /**
     * Creates message.
     *
     * @param array
     * @return Thread
     */
    public function create(array $data);
}
