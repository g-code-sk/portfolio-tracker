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
            'totalValue' => fake()->randomFloat(2, 1000, 1000000), // $this->resource->totalValue,
            'changePct' => fake()->randomFloat(2, -100, 100), // $this->resource->changePct,
            'assetCount' => fake()->numberBetween(1, 100), // $this->resource->assetCount,
        ];
    }
}
