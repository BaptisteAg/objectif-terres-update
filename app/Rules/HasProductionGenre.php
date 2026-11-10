<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class HasProductionGenre implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $productionGenres)
    {
        return is_array($productionGenres) && count($productionGenres) > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Vous devez sélectionner au moins une production envisagée';
    }
}
