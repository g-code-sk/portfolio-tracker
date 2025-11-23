<?php

declare(strict_types=1);

namespace App\Domain\Security\Resources;

use App\Models\Security;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Security $resource
 */
final class SecurityResource extends JsonResource
{
    /**
     * @return array{
     *     id: int,
     *     symbol: string,
     *     description: string,
     *     displaySymbol: string,
     *     type: string
     * }
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'symbol' => $this->resource->symbol,
            'description' => $this->resource->description,
            'displaySymbol' => $this->resource->display_symbol,
            'type' => $this->resource->type,
        ];
    }
}
