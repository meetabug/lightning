<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Inertia\Inertia;
use Throwable;
use Illuminate\Support\Facades\App;


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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $response =  parent::render($request, $exception);
        $status = $response->getStatusCode();
        $errorCodes = [
            401 => 'Unauthorized',
            403 => $exception->getMessage() ?: 'Forbidden',
            404 => 'Not Found',
            419 => 'Page Expired',
            429 => 'Too Many Requests',
            500 => 'Server Error',
            503 => $exception->getMessage() ?: 'Service Unavailable',
        ];

        if (App::environment('production')
        && in_array($status, array_keys($errorCodes))) {
        return Inertia::render('Error', [
            'code' => $status,
            'message' => __($errorCodes[$status]),
        ])
            ->toResponse($request)
            ->setStatusCode($status);
        }

        return $response;
    }
}
