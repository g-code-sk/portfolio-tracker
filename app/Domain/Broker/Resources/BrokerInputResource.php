<?php

declare(strict_types=1);

namespace App\Domain\Broker\Resources;

use App\Models\Broker;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Broker $resource
 */
final class BrokerInputResource extends JsonResource
{
    /**
     * @return array{value: int, label: string}
     */
    public function toArray(Request $request): array
    {
        return [
            'value' => $this->resource->id,
            'label' => $this->resource->name,
        ];
    }
}
