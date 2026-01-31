<?php

declare(strict_types=1);

namespace App\Domain\TransactionType\Resources;

use App\Models\TransactionType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read TransactionType $resource
 */
final class TransactionTypeInputResource extends JsonResource
{
    /**
     * @return array{value: number, label: string}
     */
    public function toArray(Request $request): array
    {
        return [
            'value' => $this->resource->id,
            'label' => $this->resource->name,
        ];
    }
}
