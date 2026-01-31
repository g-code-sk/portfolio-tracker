<?php

use App\Domain\Auth\Controllers\AuthController;
use App\Domain\Currency\Controllers\CurrencyController;
use App\Domain\Finnhub\Controllers\FinnhubStockSearchController;
use App\Domain\Portfolio\Controllers\UserPortfolioController;
use App\Domain\BrokerType\Controllers\BrokerTypeInputController;
use App\Domain\TransactionType\Controllers\TransactionTypeInputController;
use App\Domain\Transaction\Controllers\UserPortfolioTransactionController;
use App\Domain\Transaction\Controllers\UserTransactionController;
use App\Http\Controllers\TestController;
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
            Route::delete('/{portfolio}', [UserPortfolioController::class, 'destroy'])->name('destroy');
            Route::get('/{portfolio}/transactions', [UserPortfolioTransactionController::class, 'index'])->name('transactions.index');
        });

        // Route::get('/transactions', [UserTransactionController::class, 'index'])->name('transactions.index');
        Route::post('/transactions', [UserTransactionController::class, 'store'])->name('transactions.store');
        Route::post('/transactions/import', [UserTransactionController::class, 'import'])->name('transactions.import');
    });

    Route::get('/broker-types/input', [BrokerTypeInputController::class, 'index'])->name('broker-types.input.index');
    Route::get('/transaction-types/input', [TransactionTypeInputController::class, 'index'])->name('transaction-types.input.index');

    // Device/session management
    Route::get('/devices', [AuthController::class, 'devices']);
    Route::delete('/devices/{tokenId}', [AuthController::class, 'revokeDevice']);
});

Route::get('test', [TestController::class, 'index']);
