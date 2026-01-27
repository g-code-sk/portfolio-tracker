<?php

declare(strict_types=1);

namespace App\Domain\Finnhub\Actions;

use App\Domain\Finnhub\Data\FinnhubCurrentPriceData;
use App\Services\HttpClientService;
use Illuminate\Support\Facades\Log;
use RuntimeException;

final class FinnhubGetCurrentPriceInfoAction
{
    private readonly string $apiToken;

    public function __construct()
    {
        $this->apiToken = config('services.finnhub.token');

        if (empty($this->apiToken)) {
            throw new RuntimeException('FinnhubGetCurrentPriceInfoAction: API token is not set in .env file');
        }
    }

    public function executeQuery(string $symbol): FinnhubCurrentPriceData
    {
        $response = app(HttpClientService::class)->client()
            ->get('https://finnhub.io/api/v1/quote', [
                'symbol' => $symbol,
                'token' => $this->apiToken,
            ]);

        if (! $response->successful()) {
            Log::error('FinnhubGetCurrentPriceInfoAction API error', [
                'status' => $response->status(),
                'body' => $response->body(),
                'symbol' => $symbol,
            ]);

            throw new RuntimeException(
                "FinnhubGetCurrentPriceInfoAction: Finnhub API request failed with status {$response->status()} "
            );
        }

        $data = $response->json();

        if (! $this->isQuoteDataValid($data)) {
            Log::error('FinnhubGetCurrentPriceInfoAction returned invalid data', [
                'symbol' => $symbol,
                'data' => $data,
            ]);

            throw new RuntimeException('FinnhubGetCurrentPriceInfoAction: Finnhub quote returned invalid data');
        }

        return FinnhubCurrentPriceData::fromResponse($data);
    }

    private function isQuoteDataValid(array $data): bool
    {
        return isset($data['c']) && $data['c'] > 0;
    }
}
