<?php

use App\Domain\Auth\Controllers\Api\AuthController;
use App\Domain\Currency\Controllers\Api\CurrencyController;
use App\Domain\Finnhub\Controllers\Api\FinnhubStockSearchController;
use App\Domain\Portfolio\Controllers\Api\UserPortfolioController;
use App\Http\Controllers\Api\TestController;
use Illuminate\Support\Facades\Route;

// Public routes (token-based authentication)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (requires Bearer token)
Route::middleware('auth:sanctum')->group(function () {
    // Authentication
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutAll']);
    Route::get('/user', [AuthController::class, 'user']);

    // Currencies
    Route::get('/currencies', [CurrencyController::class, 'index']);

    // Stock search
    Route::get('/finnhub/stocks/search', [FinnhubStockSearchController::class, 'search']);

    // User routes
    Route::prefix('user')->as('user.')->group(function () {
        Route::get('/portfolios', [UserPortfolioController::class, 'index'])->name('portfolios.index');
        Route::post('/portfolios', [UserPortfolioController::class, 'store'])->name('portfolios.store');
        Route::get('/portfolios/{portfolio}', [UserPortfolioController::class, 'show'])->name('portfolios.show');
    });

    // Device/session management
    Route::get('/devices', [AuthController::class, 'devices']);
    Route::delete('/devices/{tokenId}', [AuthController::class, 'revokeDevice']);
});

Route::get('test', [TestController::class, 'index']);
