<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * Success response method.
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function sendResponse($data, string $message = 'Success', int $code = 200): JsonResponse
    {
        $response = [
            'status' => true,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $code);
    }

    /**
     * Error response method.
     *
     * @param string $message
     * @param mixed $data
     * @param int $code
     * @return JsonResponse
     */
    public function sendError(string $message, $data = null, int $code = 400): JsonResponse
    {
        $response = [
            'status' => false,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $code);
    }

    /**
     * Validation error response method.
     *
     * @param mixed $errors
     * @param string $message
     * @return JsonResponse
     */
    public function sendValidationError($errors, string $message = 'Validation Error'): JsonResponse
    {
        $response = [
            'status' => false,
            'message' => $message,
            'data' => $errors,
        ];

        return response()->json($response, 422);
    }
}
