<?php

declare(strict_types=1);

namespace App\Domain\Finnhub\Actions;

use App\Domain\Finnhub\Data\FinnhubStockSearchData;
use App\Domain\Finnhub\Data\FinnhubStockSearchItemData;
use App\Services\HttpClientService;
use Illuminate\Support\Facades\Log;
use RuntimeException;

final class FinnhubSearchStockAction
{
    private readonly string $apiToken;

    public function __construct()
    {
        $this->apiToken = config('services.finnhub.token');

        if (empty($this->apiToken)) {
            throw new RuntimeException('FinnhubSearchStockAction: API token is not set in .env file');
        }
    }

    public function executeQuery(string $query): FinnhubStockSearchData
    {
        $response = app(HttpClientService::class)->client()
            ->get('https://finnhub.io/api/v1/search', [
                'q' => $query,
                'token' => $this->apiToken,
            ]);

        if (! $response->successful()) {
            Log::error('Finnhub API error', [
                'status' => $response->status(),
                'body' => $response->body(),
                'query' => $query,
            ]);

            throw new RuntimeException(
                "FinnhubSearchStockAction: Finnhub API request failed with status {$response->status()}"
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
    }
}
