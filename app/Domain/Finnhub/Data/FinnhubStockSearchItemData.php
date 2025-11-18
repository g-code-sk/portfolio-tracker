<?php

declare(strict_types=1);

namespace App\Domain\Finnhub\Data;

use Spatie\LaravelData\Data;

final class FinnhubStockSearchItemData extends Data
{
    public function __construct(
        public string $description,
        public string $displaySymbol,
        public string $symbol,
        public string $type,
    ) {}
}
