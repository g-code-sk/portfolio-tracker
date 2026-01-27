<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Actions;


use App\Domain\Security\Actions\FindOrCreateSecurityAction;
use App\Domain\Transaction\Data\CreateUserTransactionData;
use App\Models\Security;
use App\Models\Transaction;

final class CreateUserTransactionAction
{
    public function __construct() {}

    public function execute(CreateUserTransactionData $requestData, int $userId): Transaction
    {
        $security = Security::where('symbol', $requestData->stockSymbol)->first();

        if (! $security) {
            $security = app(FindOrCreateSecurityAction::class)->execute($requestData->stockSymbol);
        }

        $transaction = Transaction::create([
            'user_id' => $userId,
            'portfolio_id' => $requestData->portfolioId,
            'security_id' => $security->id,
            'amount' => $requestData->amount,
            'price' => $requestData->price,
            'date' => $requestData->date,
            'fee' => $requestData->fee,
        ]);

        return $transaction;
    }
}
