<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected function renderHttpException(HttpExceptionInterface $e)
    {
        if ($e->getStatusCode() === 419) {
            return back()->withInput()->withErrors('La page a expiré. Merci de réessayer.');
        }

        if (! view()->exists("errors.{$e->getStatusCode()}")) {
            return response()->view('errors.default', ['exception' => $e], $e->getStatusCode(), $e->getHeaders());
        }

        return parent::renderHttpException($e);
    }
}
