<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable as ThrowableAlias;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [];

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
     * @param Exception|ThrowableAlias $e
     * @return void
     * @throws ThrowableAlias
     */
    public function report(Exception|ThrowableAlias $e): void
    {
        parent::report($e);
    }


    /**
     * Render an exception into an HTTP response.
     *
     * @param $request
     * @param Exception|ThrowableAlias $e
     * @return JsonResponse|Response
     * @throws ThrowableAlias
     */
    public function render($request, Exception|ThrowableAlias $e): JsonResponse|Response
    {
        if ($e instanceof ApiException) {
            return $e->render($request);
        }

        return parent::render($request, $e);
    }
}
