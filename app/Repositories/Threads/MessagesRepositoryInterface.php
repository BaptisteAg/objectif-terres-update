<?php

namespace App\Repositories\Threads;

use App\Models\Message;

interface MessagesRepositoryInterface
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
     * @return Message[]
     */
    public function all($paginate = null);

    /**
     * Gets message by User ID .
     *
     * @return Message[]
     */
    public function findAllByThread(string $threadId);

    /**
     * Gets most recent message .
     *
     * @return Message
     */
    public function findNewestMessage();

    /**
     * Creates message.
     *
     * @param array
     */
    public function create(array $data): Message;
}
