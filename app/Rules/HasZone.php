<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class HasZone implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $locationable)
    {
        return is_array($locationable) && count($locationable) > 0 && (
            count($locationable['cities']) ||
            count($locationable['departments']) ||
            count($locationable['regions'])
        );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Vous devez sélectionner au moins une zone géographique";
    }
}
