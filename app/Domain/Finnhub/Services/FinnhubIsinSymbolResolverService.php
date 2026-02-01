<?php

declare(strict_types=1);

namespace App\Domain\Finnhub\Services;

final class FinnhubIsinSymbolResolverService
{
    /**
     * Resolve a base ticker to a Finnhub exchange-specific symbol using ISIN.
     *
     * The country code is extracted from the ISIN (first 2 characters) and used
     * to determine the appropriate exchange suffix for that market.
     *
     * @param string $ticker Base ticker (e.g. "VUSA") or already-qualified symbol (e.g. "VUSA.L")
     * @param string|null $isin ISIN (e.g. "IE00B3XXRP09") - country derived from first 2 chars
     */
    public function resolve(string $ticker, string $isin): string
    {
        $ticker = trim($ticker);
        $isin = trim($isin);

        if (str_contains($ticker, '.')) {
            return $ticker;
        }

        $countryCode = $this->getCountryFromIsin($isin);

        if ($countryCode === null) {
            return $ticker;
        }

        $suffix = $this->getExchangeSuffixForCountry($countryCode);

        if ($suffix === null) {
            return $ticker;
        }

        return $ticker . '.' . $suffix;
    }

    public function getCountryFromIsin(string $isin): string
    {
        return strtoupper(substr($isin, 0, 2));
    }

    public function getExchangeSuffixForCountry(string $countryCode): string
    {
        $mapping = config('finnhub_exchange_by_country', []);

        return $mapping[strtoupper($countryCode)];
    }
}
