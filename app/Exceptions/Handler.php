<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($request->wantsJson()) {
            return $this->handleApiException($request, $e);
        } else {
            $retval = parent::render($request, $e);
        }

        return $retval;
    }

    private function handleApiException($request, $exception)
    {
        $exception = $this->prepareException($exception);

        if ($exception instanceof \Illuminate\Http\Exceptions\HttpResponseException) {
            $exception = $exception->getResponse();
        }

        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            $exception = $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            $exception = $this->convertValidationExceptionToResponse($exception, $request);
        }

        return $this->customApiResponse($exception);
    }

    private function customApiResponse($exception)
    {
        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = 500;
        }

        $response = [];

        $response['code'] = $statusCode;

        switch ($statusCode) {
            case 401:
                $response['errors'][] = ['type' => 'forbidden_action', 'text' => 'Недостаточно прав'];
                break;
            case 403:
                $response['errors'][] = ['type' => 'forbidden_action', 'text' => 'Доступ запрещен'];
                break;
            case 404:
                $response['errors'][] = ['type' => 'not_found', 'text' => 'Не найдено'];
                break;
            case 405:
                $response['errors'][] = ['type' => 'method_not_supported', 'text' => 'Метод не поддерживается'];
                break;
            case 422:
                $response['text'] = $exception->original['message'];
                $response['errors'] = [];

                if ($errors = $exception->original['errors']) {
                    foreach ($errors as $errorType => $error) {
                        $response['errors'][] = ['type' => $errorType, 'text' => $error[0]];
                    }
                }

                break;
            default:
                $response['text'] = $exception->getMessage();
                break;
        }

        if (config('app.debug')) {
            $response['trace'] = method_exists($exception, 'getTrace')
                ? $exception->getTrace()
                : $exception;
        }

        return response()->json($response, $statusCode);
    }
}
