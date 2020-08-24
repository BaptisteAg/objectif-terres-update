<?php

namespace App\Rules;

use App\Services\Salesforce\SalesforceService;
use Illuminate\Contracts\Validation\Rule;

class SalesforceUniqueEmail implements Rule
{
    /**
     * @var SalesforceService
     */
    protected $salesforceService;

    public function __construct(SalesforceService $salesforceService)
    {
        $this->salesforceService = $salesforceService;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $email)
    {
        return !$this->salesforceService->usernameExists($email, 'Contact');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Cet email existe déjà dans notre base de données. Utilisez une autre adresse, connectez-vous avec l'existante, ou utilisez la fonction de mot de passe oublié.";
    }
}
