<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // Handle API routes with JSON responses
        if ($request->is('api/*')) {
            if ($exception instanceof MethodNotAllowedHttpException) {
                return response()->json([
                    'status' => false,
                    'message' => 'Method not allowed for this endpoint.',
                    'data' => [
                        'allowed_methods' => explode(', ', $exception->getHeaders()['Allow'] ?? ''),
                        'requested_method' => $request->method(),
                        'endpoint' => $request->path()
                    ]
                ], 405);
            }

            if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'status' => false,
                    'message' => 'Endpoint not found.',
                    'data' => [
                        'endpoint' => $request->path(),
                        'method' => $request->method()
                    ]
                ], 404);
            }

            if ($exception instanceof \Illuminate\Validation\ValidationException) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'data' => $exception->errors()
                ], 422);
            }

            // Handle other exceptions for API routes
            return response()->json([
                'status' => false,
                'message' => 'Internal server error.',
                'data' => [
                    'error' => config('app.debug') ? $exception->getMessage() : 'Something went wrong.'
                ]
            ], 500);
        }

        return parent::render($request, $exception);
    }
}
