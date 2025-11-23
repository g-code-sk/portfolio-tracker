<?php

declare(strict_types=1);

namespace App\Domain\Finnhub\Data;

use Spatie\LaravelData\Data;

final class FinnhubQuoteData extends Data
{
    public function __construct(
        public float $currentPrice,
        public float $change,
        public float $percentChange,
        public float $highPrice,
        public float $lowPrice,
        public float $openPrice,
        public float $previousClosePrice,
        public int $timestamp,
    ) {}

    /**
     * Create instance from Finnhub API response
     *
     * @param array{c?: float, d?: float, dp?: float, h?: float, l?: float, o?: float, pc?: float, t?: int} $data
     */
    public static function fromResponse(array $data): self
    {
        return new self(
            currentPrice: $data['c'] ?? 0.0,
            change: $data['d'] ?? 0.0,
            percentChange: $data['dp'] ?? 0.0,
            highPrice: $data['h'] ?? 0.0,
            lowPrice: $data['l'] ?? 0.0,
            openPrice: $data['o'] ?? 0.0,
            previousClosePrice: $data['pc'] ?? 0.0,
            timestamp: $data['t'] ?? 0,
        );
    }
}
