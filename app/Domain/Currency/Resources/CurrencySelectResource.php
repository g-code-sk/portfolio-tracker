<?php

declare(strict_types=1);

namespace App\Domain\Currency\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $code
 */
final class CurrencySelectResource extends JsonResource
{
    /**
     * @return array{label: string, value: int}
     */
    public function toArray(Request $request): array
    {
        return [
            'label' => sprintf('%s (%s)', $this->name, $this->code),
            'value' => $this->id,
        ];
    }
}
