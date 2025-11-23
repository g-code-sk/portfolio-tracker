<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Actions;

use App\Domain\Finnhub\Actions\FinnhubGetQuoteAction;
use App\Domain\Finnhub\Actions\FinnhubSearchStockAction;
use App\Domain\Transaction\Data\CreateUserTransactionData;
use App\Models\Security;
use App\Models\Transaction;
use Illuminate\Support\Collection;

final class CreateUserTransactionAction
{
    public function __construct(
        private readonly FinnhubGetQuoteAction $getQuoteAction,
        private readonly FinnhubSearchStockAction $searchStockAction,
    ) {}

    public function execute(CreateUserTransactionData $data, int $userId): Transaction
    {
        // Fetch security basic data from Finnhub
        $searchResults = $this->searchStockAction->execute($data->stockSymbol);
        $quote = $this->getQuoteAction->execute($data->stockSymbol);

        // Find matching stock in search results
        $stockInfo = collect($searchResults->items)->first(
            fn($item) => strtoupper($item->symbol) === strtoupper($data->stockSymbol)
        );

        // Prepare security data with fetched information
        $securityData = [
            'symbol' => $data->stockSymbol,
            'description' => $stockInfo?->description ?? $data->stockSymbol,
            'display_symbol' => $stockInfo?->displaySymbol ?? $data->stockSymbol,
            'type' => $stockInfo?->type ?? 'Common Stock',
        ];

        // Find or create security by symbol
        $security = Security::firstOrCreate(
            ['symbol' => $data->stockSymbol],
            $securityData
        );

        $transaction = Transaction::create([
            'user_id' => $userId,
            'portfolio_id' => $data->portfolioId,
            'security_id' => $security->id,
            'amount' => $data->amount,
            'price' => $data->price,
            'date' => $data->date,
            'fee' => $data->fee,
        ]);

        return $transaction;
    }
}
