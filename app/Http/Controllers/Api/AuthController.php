<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    /**
     * Login user and create token
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->sendError('Invalid credentials.', null, 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        $user->load(['country', 'city', 'branch', 'roles']);

        return $this->sendResponse([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Login successful.');
    }

    /**
     * Logout user (revoke token)
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->sendResponse(null, 'Logout successful.');
    }

    /**
     * Get authenticated user
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->load(['country', 'city', 'branch', 'roles']);

        return $this->sendResponse($user, 'User retrieved successfully.');
    }

    /**
     * Super Admin impersonation
     */
    public function impersonate(Request $request, string $userId): JsonResponse
    {
        // Check if current user is Super Admin
        if (!$request->user()->hasRole('Super Admin')) {
            return $this->sendError('Unauthorized. Only Super Admin can impersonate users.', null, 403);
        }

        $user = User::find($userId);

        if (is_null($user)) {
            return $this->sendError('User not found.');
        }

        // Revoke current token
        $request->user()->currentAccessToken()->delete();

        // Create new token for the impersonated user
        $token = $user->createToken('impersonation_token')->plainTextToken;

        $user->load(['country', 'city', 'branch', 'roles']);

        return $this->sendResponse([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
            'impersonated' => true,
        ], 'Impersonation successful.');
    }

    /**
     * Stop impersonation and return to Super Admin
     */
    public function stopImpersonation(Request $request): JsonResponse
    {
        // This would require storing the original Super Admin user ID
        // For now, we'll just return an error suggesting to login again
        return $this->sendError('Please login again to stop impersonation.', null, 400);
    }
}
