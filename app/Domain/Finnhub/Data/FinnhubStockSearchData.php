<?php

declare(strict_types=1);

namespace App\Domain\Finnhub\Data;

use Spatie\LaravelData\Data;

final class FinnhubStockSearchData extends Data
{
    /**
     * @param array<int, FinnhubStockSearchItemData> $items
     */
    public function __construct(
        public int $count,
        public array $items,
    ) {}
}
