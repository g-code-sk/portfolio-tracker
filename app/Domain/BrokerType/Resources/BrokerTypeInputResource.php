<?php

declare(strict_types=1);

namespace App\Domain\BrokerType\Resources;

use App\Models\BrokerType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read BrokerType $resource
 */
final class BrokerTypeInputResource extends JsonResource
{
    /**
     * @return array{id: int, name: string}
     */
    public function toArray(Request $request): array
    {
        return [
            'value' => $this->resource->id,
            'label' => $this->resource->name,
        ];
    }
}
