<?php

declare(strict_types=1);

namespace App\Domain\Finnhub\Actions;

use App\Domain\Finnhub\Data\FinnhubCompanyProfileData;
use App\Services\HttpClientService;
use Illuminate\Support\Facades\Log;
use RuntimeException;

final class FinnhubGetCompanyProfileAction
{
    private readonly string $apiToken;

    public function __construct()
    {
        $this->apiToken = config('services.finnhub.token');

        if (empty($this->apiToken)) {
            throw new RuntimeException('FinnhubGetCompanyProfileAction: API token is not set in .env file');
        }
    }

    public function executeQuery(string $symbol): FinnhubCompanyProfileData
    {
        $response = app(HttpClientService::class)->client()
            ->get('https://finnhub.io/api/v1/stock/profile2', [
                'symbol' => $symbol,
                'token' => $this->apiToken,
            ]);

        if (! $response->successful()) {
            Log::error('FinnhubGetCompanyProfileAction API error', [
                'status' => $response->status(),
                'body' => $response->body(),
                'symbol' => $symbol,
            ]);

            throw new RuntimeException(
                "FinnhubGetCompanyProfileAction: Finnhub API request failed with status {$response->status()} "
            );
        }

        $data = $response->json();

        if (! $this->isCompanyProfileDataValid($data)) {
            Log::error('FinnhubGetCompanyProfileAction returned empty or invalid data', [
                'symbol' => $symbol,
                'data' => $data,
            ]);

            throw new RuntimeException('FinnhubGetCompanyProfileAction: Finnhub company profile returned empty or invalid data');
        }

        return FinnhubCompanyProfileData::fromResponse($data);
    }

    private function isCompanyProfileDataValid(array $data): bool
    {
        return ! empty($data) && is_array($data);
    }
}
