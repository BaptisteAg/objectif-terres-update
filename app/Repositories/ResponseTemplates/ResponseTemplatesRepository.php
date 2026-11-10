<?php

namespace App\Repositories\ResponseTemplates;

use App\Models\ResponseTemplate;

class ResponseTemplatesRepository implements ResponseTemplatesRepositoryInterface
{
    /**
     * @return string
     */
    public function entity()
    {
        return ResponseTemplate::class;
    }

    public function create(array $data): ResponseTemplate
    {
        $responseTemplate = new ResponseTemplate;
        $responseTemplate->fill($data);
        $responseTemplate->save();

        return $responseTemplate;
    }

    public function edit(int $responseTemplateId, array $data): ResponseTemplate
    {
        $responseTemplate = ResponseTemplate::find($responseTemplateId);
        $responseTemplate->fill($data);
        $responseTemplate->save();

        return $responseTemplate;
    }
}
