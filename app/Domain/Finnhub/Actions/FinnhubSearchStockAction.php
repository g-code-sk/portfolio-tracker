<?php

declare(strict_types=1);

namespace App\Domain\Finnhub\Actions;

use App\Domain\Finnhub\Data\FinnhubStockSearchData;
use App\Domain\Finnhub\Data\FinnhubStockSearchItemData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class FinnhubSearchStockAction
{
    public function __construct(
        private readonly string $apiToken,
    ) {}

    public function execute(string $query): FinnhubStockSearchData
    {
        try {
            $response = Http::timeout(10)->get('https://finnhub.io/api/v1/search', [
                'q' => $query,
                'token' => $this->apiToken,
            ]);

            if (! $response->successful()) {
                Log::error('Finnhub API error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return new FinnhubStockSearchData(
                    count: 0,
                    items: [],
                );
            }

            $data = $response->json();

            $results = array_map(
                fn(array $item): FinnhubStockSearchItemData => FinnhubStockSearchItemData::from($item),
                $data['result'] ?? []
            );

            return new FinnhubStockSearchData(
                count: $data['count'] ?? 0,
                items: $results,
            );
        } catch (\Exception $e) {
            Log::error('Finnhub API exception', [
                'message' => $e->getMessage(),
                'query' => $query,
            ]);

            return new FinnhubStockSearchData(
                count: 0,
                items: [],
            );
        }
    }
}
