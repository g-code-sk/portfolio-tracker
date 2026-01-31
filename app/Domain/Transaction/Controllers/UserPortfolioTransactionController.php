<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Controllers;

use App\Domain\Transaction\Resources\UserTransactionResource;
use App\Models\Portfolio;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class UserPortfolioTransactionController
{
    use AuthorizesRequests;

    public function __construct() {}

    public function index(Request $request, Portfolio $portfolio): JsonResource
    {
        $this->authorize('userIndex', $portfolio);

        $transactions = $portfolio->transactions()
            ->with(['security', 'portfolio.currency'])
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->get();

        return UserTransactionResource::collection($transactions);
    }
}
