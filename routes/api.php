<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\TerminalController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // Super Admin impersonation
    Route::post('/impersonate/{user_id}', [AuthController::class, 'impersonate'])
        ->middleware('role:Super Admin');
    Route::post('/stop-impersonation', [AuthController::class, 'stopImpersonation']);

    // Country routes
    Route::apiResource('countries', CountryController::class);
    
    // City routes
    Route::apiResource('cities', CityController::class);
    
    // Company routes
    Route::apiResource('companies', CompanyController::class);
    
    // Branch routes
    Route::apiResource('branches', BranchController::class);
    
    // Terminal routes
    Route::apiResource('terminals', TerminalController::class);
    
    // User routes
    Route::apiResource('users', UserController::class);
});
