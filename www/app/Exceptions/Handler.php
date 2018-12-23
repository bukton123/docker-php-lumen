<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $err = class_basename( $exception );
        $check = strpos($err, "NotFoundHttpException");
        $checkMethod = strpos($err, "MethodNotAllowedHttpException");
   
        $msg = [
            "status" => "NOT_FOUND",
            "message" => "Unsupported API call.",
            "timestamp" => gmdate("Y-m-d\TH:i:s\Z")
        ];
        if (!empty($check) || $check === 0) {
            return response()->json($msg, 404);
        } else if (!empty($checkMethod) || $checkMethod === 0) {
            return response()->json($msg, 404);
        }

        if (!env('APP_DEBUG')) {
            return response()->json([
                "status" => "ERROR",
                "message" => "Server Error"
            ], 500);
        }

        return response()->json( [
            "status" => "ERROR",
            'error' => [
                'exception' => class_basename( $exception ) . ' in ' . basename( $exception->getFile() ) . ' line ' . $exception->getLine() . ': ' . $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]
        ], 500);

        // return parent::render($request, $exception);
    }
}
