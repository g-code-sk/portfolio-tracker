<?php

declare(strict_types=1);

namespace App\Domain\Finnhub\Resources;

use App\Domain\Finnhub\Data\FinnhubStockSearchData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read FinnhubStockSearchData $resource
 */
final class FinnhubStockSearchResource extends JsonResource
{
    /**
     * @return array{
     *     data: array{
     *         count: int,
     *         items: array<int, array{
     *             description: string,
     *             displaySymbol: string,
     *             symbol: string,
     *             type: string,
     *         }>
     *     },
     *     message: string|null
     * }
     */
    public function toArray(Request $request): array
    {
        return [
            'count' => $this->resource->count,
            'items' => $this->resource->items,
        ];
    }
}
