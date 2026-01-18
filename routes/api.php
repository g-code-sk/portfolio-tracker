<?php

use App\Domain\Auth\Controllers\Api\AuthController;
use App\Domain\Currency\Controllers\Api\CurrencyController;
use App\Domain\Finnhub\Controllers\Api\FinnhubStockSearchController;
use App\Domain\Portfolio\Controllers\Api\UserPortfolioController;
use App\Domain\Transaction\Controllers\Api\UserPortfolioTransactionController;
use App\Domain\Transaction\Controllers\Api\UserTransactionController;
use App\Http\Controllers\Api\TestController;
use App\Models\Portfolio;
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
        Route::prefix('portfolios')->as('portfolios.')->group(function () {
            Route::get('/', [UserPortfolioController::class, 'index'])->name('index');
            Route::post('/', [UserPortfolioController::class, 'store'])->name('store');
            Route::get('/{portfolio}', [UserPortfolioController::class, 'show'])->name('show');
            Route::get('/{portfolio}/transactions', [UserPortfolioTransactionController::class, 'index'])->name('transactions.index');
        });

        Route::get('/transactions', [UserTransactionController::class, 'index'])->name('transactions.index');
        Route::post('/transactions', [UserTransactionController::class, 'store'])->name('transactions.store');
    });

    // Device/session management
    Route::get('/devices', [AuthController::class, 'devices']);
    Route::delete('/devices/{tokenId}', [AuthController::class, 'revokeDevice']);
});

Route::get('test', [TestController::class, 'index']);
