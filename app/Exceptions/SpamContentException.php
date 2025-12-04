<?php

namespace App\Exceptions;

use Exception;

class SpamContentException extends Exception
{
    /**
     * Create a new spam content exception.
     *
     * @param string $message
     */
    public function __construct(string $message = 'Votre message contient du contenu non autorisé.')
    {
        parent::__construct($message);
    }
}
