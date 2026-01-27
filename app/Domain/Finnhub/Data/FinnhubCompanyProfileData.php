<?php

declare(strict_types=1);

namespace App\Domain\Finnhub\Data;

use Spatie\LaravelData\Data;

final class FinnhubCompanyProfileData extends Data
{
    public function __construct(
        public ?string $country,
        public ?string $currency,
        public ?string $exchange,
        public ?string $finnhubIndustry,
        public ?string $ipo,
        public ?string $logo,
        public ?float $marketCapitalization,
        public ?string $name,
        public ?string $phone,
        public ?float $shareOutstanding,
        public ?string $ticker,
        public ?string $weburl,
    ) {}

    /**
     * Create instance from Finnhub API response
     *
     * @param array{
     *     country?: string,
     *     currency?: string,
     *     exchange?: string,
     *     finnhubIndustry?: string,
     *     ipo?: string,
     *     logo?: string,
     *     marketCapitalization?: float,
     *     name?: string,
     *     phone?: string,
     *     shareOutstanding?: float,
     *     ticker?: string,
     *     weburl?: string
     * } $data
     */
    public static function fromResponse(array $data): self
    {
        return new self(
            country: $data['country'] ?? null,
            currency: $data['currency'] ?? null,
            exchange: $data['exchange'] ?? null,
            finnhubIndustry: $data['finnhubIndustry'] ?? null,
            ipo: $data['ipo'] ?? null,
            logo: $data['logo'] ?? null,
            marketCapitalization: $data['marketCapitalization'] ?? null,
            name: $data['name'] ?? null,
            phone: $data['phone'] ?? null,
            shareOutstanding: $data['shareOutstanding'] ?? null,
            ticker: $data['ticker'] ?? null,
            weburl: $data['weburl'] ?? null,
        );
    }
}
