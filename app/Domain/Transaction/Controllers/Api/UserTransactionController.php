<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Controllers\Api;

use App\Domain\Transaction\Actions\CreateUserTransactionAction;
use App\Domain\Transaction\Data\CreateUserTransactionData;
use App\Domain\Transaction\Resources\UserTransactionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class UserTransactionController
{
    public function __construct(
        private readonly CreateUserTransactionAction $createUserTransactionAction,
    ) {}

    public function store(CreateUserTransactionData $data, Request $request): JsonResource
    {
        $transaction = $this->createUserTransactionAction->execute($data, $request->user()->id);
        $transaction->loadMissing(['security', 'portfolio']);

        return (new UserTransactionResource($transaction))
            ->additional(['message' => 'Transaction created successfully']);
    }
}
