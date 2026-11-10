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
        try {
            return ! $this->salesforceService->usernameExists($email, 'User');
        } catch (\Exception $e) {
            logger()->error('SalesforceUniqueEmail: could not validate, skipping rule', [
                'error' => $e->getMessage(),
            ]);

            return true;
        }
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
