<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @param \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if (config('app.debug')) {
            return parent::render($request, $e);
        }

        $message = $e->getMessage();
        $code = $e->getCode();


        if ($e instanceof NotFoundHttpException) {
            $message = 'Resource not found.';
            $code = '404';
        }
        // Define the response
        $response = [
            'error' => [
                'message' => $message,
                'code' => $code
            ]
        ];
        // Return a JSON response with the response array and status code
        return response()->json($response, 400);
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param \Illuminate\Validation\ValidationException $e
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($e->response) {
            return $e->response;
        }

        return response()->json(['error' => $e->validator->errors()->getMessages()], 422);
    }
}
