<?php

declare(strict_types=1);

namespace App\Domain\Portfolio\Resources;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Portfolio $resource
 */
final class UserPortfolioResource extends JsonResource
{
    /**
     * @return array{
     *     id: int,
     *     name: string,
     *     baseCurrency: string,
     *     totalValue: float,
     *     changePct: float,
     *     assetCount: int
     * }
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'baseCurrency' => $this->resource->currency->code,
            'totalValue' => 0, // $this->resource->totalValue,
            'changePct' => 0, // $this->resource->changePct,
            'assetCount' => 0, // $this->resource->assetCount,
        ];
    }
}
