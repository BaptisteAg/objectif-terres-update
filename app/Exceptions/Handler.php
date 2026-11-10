<?php

namespace App\Exceptions;

use Exception;
use GlueDev\Laravel\Stackdriver\StackdriverExceptionHandler;
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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @return void
     *
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        StackdriverExceptionHandler::report($exception);
        parent::report($exception);
    }

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
