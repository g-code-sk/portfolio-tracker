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

    public function execute(CreateUserTransactionData $transactionData, int $userId, ?string $isin = null): Transaction
    {
        $security = Security::where('symbol', $transactionData->stockSymbol)->first();

        if (! $security) {
            $security = app(FindOrCreateSecurityAction::class)->execute($transactionData->stockSymbol, $isin);
        }

        $transaction = Transaction::create([
            'user_id' => $userId,
            'portfolio_id' => $transactionData->portfolioId,
            'security_id' => $security->id,
            'transaction_type_id' => $transactionData->transactionTypeId,
            'amount' => $transactionData->amount,
            'price' => $transactionData->price,
            'date' => $transactionData->date,
            'fee' => $transactionData->fee,
            'external_id' => $transactionData->externalId,
        ]);

        return $transaction;
    }
}
