<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Resources;

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
     *     createdAt: string,
     *     updatedAt: string
     * }
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'portfolioId' => $this->resource->portfolio_id,
            'security' => new SecurityResource($this->resource->security),
            'amount' => (string) $this->resource->amount,
            'price' => (string) $this->resource->price,
            'date' => $this->resource->date->format('Y-m-d'),
            'fee' => (string) $this->resource->fee,
            'createdAt' => $this->resource->created_at->toISOString(),
            'updatedAt' => $this->resource->updated_at->toISOString(),
        ];
    }
}
