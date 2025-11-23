<?php

declare(strict_types=1);

namespace App\Domain\Finnhub\Actions;

use App\Domain\Finnhub\Data\FinnhubQuoteData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class FinnhubGetQuoteAction
{
    public function __construct(
        private readonly string $apiToken,
    ) {}

    public function execute(string $symbol): ?FinnhubQuoteData
    {
        try {
            $response = Http::timeout(10)->get('https://finnhub.io/api/v1/quote', [
                'symbol' => $symbol,
                'token' => $this->apiToken,
            ]);

            if (! $response->successful()) {
                Log::warning('Finnhub quote API error', [
                    'symbol' => $symbol,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return null;
            }

            $data = $response->json();

            // Check if we have valid quote data (c = current price should be > 0)
            if (! isset($data['c']) || $data['c'] <= 0) {
                Log::warning('Finnhub quote returned invalid data', [
                    'symbol' => $symbol,
                    'data' => $data,
                ]);

                return null;
            }

            return FinnhubQuoteData::fromResponse($data);
        } catch (\Exception $e) {
            Log::error('Finnhub quote API exception', [
                'message' => $e->getMessage(),
                'symbol' => $symbol,
            ]);

            return null;
        }
    }
}
