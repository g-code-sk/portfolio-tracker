<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Resources;

use App\Domain\Currency\Services\CurrencyFormatterService;
use App\Domain\Security\Resources\SecurityResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Transaction $resource
 */
final class UserTransactionResource extends JsonResource
{
    /**
     * @return array{
     *     id: int,
     *     portfolioId: int,
     *     security: array{id: int, symbol: string, description: string, displaySymbol: string, type: string},
     *     amount: string,
     *     price: string,
     *     date: string,
     *     fee: string,
     *     formattedDate: string,
     *     formattedAmount: string,
     *     formattedPrice: string,
     *     formattedFee: string,
     *     formattedTotal: string,
     *     createdAt: string,
     *     updatedAt: string
     * }
     */
    public function toArray(Request $request): array
    {
        $currencyFormatter = app(CurrencyFormatterService::class);
        $portfolio = $this->resource->portfolio;
        $baseCurrency = $portfolio->currency->code;

        $amount = (float) $this->resource->amount;
        $price = (float) $this->resource->price;
        $fee = (float) $this->resource->fee;
        $total = $amount * $price;

        return [
            'id' => $this->resource->id,
            'portfolioId' => $this->resource->portfolio_id,
            'security' => new SecurityResource($this->resource->security),
            'amount' => (string) $this->resource->amount,
            'price' => (string) $this->resource->price,
            'date' => $this->resource->date->format('Y-m-d'),
            'fee' => (string) $this->resource->fee,
            'formattedDate' => $this->resource->date->format('M j, Y'),
            'formattedAmount' => number_format($amount, 0, '.', ','),
            'formattedPrice' => $currencyFormatter->format($price, $baseCurrency),
            'formattedFee' => $currencyFormatter->format($fee, $baseCurrency),
            'formattedTotal' => $currencyFormatter->format($total, $baseCurrency),
            'createdAt' => $this->resource->created_at->toISOString(),
            'updatedAt' => $this->resource->updated_at->toISOString(),
        ];
    }
}
