<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Controllers\Api;

use App\Domain\Transaction\Actions\CreateUserTransactionAction;
use App\Domain\Transaction\Data\CreateUserTransactionData;
use App\Domain\Transaction\Resources\UserTransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class UserTransactionController
{
    public function __construct(
        private readonly CreateUserTransactionAction $createUserTransactionAction,
    ) {}

    public function index(Request $request): JsonResource
    {
        $transactions = Transaction::query()
            ->where('user_id', $request->user()->id)
            ->with(['security', 'portfolio.currency'])
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->get();

        return UserTransactionResource::collection($transactions);
    }

    public function store(CreateUserTransactionData $data, Request $request): JsonResource
    {
        $transaction = $this->createUserTransactionAction->execute($data, $request->user()->id);
        $transaction->loadMissing(['security', 'portfolio.currency']);

        return (new UserTransactionResource($transaction))
            ->additional(['message' => 'Transaction created successfully']);
    }
}
