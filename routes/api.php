<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TestController;

// Public routes (token-based authentication)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (requires Bearer token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutAll']);
    Route::get('/user', [AuthController::class, 'user']);

    // Device/session management
    Route::get('/devices', [AuthController::class, 'devices']);
    Route::delete('/devices/{tokenId}', [AuthController::class, 'revokeDevice']);
});

Route::get('test', [TestController::class, 'index']);
