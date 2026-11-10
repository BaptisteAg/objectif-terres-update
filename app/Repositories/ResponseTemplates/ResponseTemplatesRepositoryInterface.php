<?php

namespace App\Repositories\ResponseTemplates;

interface ResponseTemplatesRepositoryInterface
{
    /**
     * Creates a response template.
     */
    public function create(array $data);
}
