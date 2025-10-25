<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ApiExceptionHandler extends ExceptionHandler
{
    /**
     * Handle API exceptions and return JSON responses
     */
    public function render($request, Throwable $exception)
    {
        // Only handle API routes
        if ($request->is('api/*')) {
            return $this->handleApiException($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Handle API-specific exceptions
     */
    private function handleApiException(Request $request, Throwable $exception): JsonResponse
    {
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'status' => false,
                'message' => 'Method not allowed for this endpoint.',
                'data' => [
                    'allowed_methods' => $exception->getHeaders()['Allow'] ?? [],
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

        if ($exception instanceof ValidationException) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data' => $exception->errors()
            ], 422);
        }

        // Handle other exceptions
        return response()->json([
            'status' => false,
            'message' => 'Internal server error.',
            'data' => [
                'error' => config('app.debug') ? $exception->getMessage() : 'Something went wrong.'
            ]
        ], 500);
    }
}
