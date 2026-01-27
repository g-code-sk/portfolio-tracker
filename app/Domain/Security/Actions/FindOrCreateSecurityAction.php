<?php

declare(strict_types=1);

namespace App\Domain\Security\Actions;

use App\Models\Security;
use App\Domain\Country\Actions\FindOrCreateCountryAction;
use App\Domain\Currency\Actions\FindOrCreateCurrencyAction;
use App\Domain\Exchange\Actions\FindOrCreateExchangeAction;
use App\Domain\Finnhub\Actions\FinnhubGetCompanyProfileAction;
use App\Domain\Finnhub\Actions\FinnhubGetCurrentPriceInfoAction;
use App\Domain\Finnhub\Actions\FinnhubSearchStockAction;
use App\Domain\Security\Actions\FindOrCreateSecurityTypeAction;

final class FindOrCreateSecurityAction
{
    public function execute(string $stockSymbol,): Security
    {
        $searchResultsData = app(FinnhubSearchStockAction::class)->executeQuery($stockSymbol);
        $currentPriceData = app(FinnhubGetCurrentPriceInfoAction::class)->executeQuery($stockSymbol);
        $companyProfileData = app(FinnhubGetCompanyProfileAction::class)->executeQuery($stockSymbol);

        // if one of the queries fail, exception is thrown and the transaction is not created

        $stockSearchData = $searchResultsData->findBySymbol($stockSymbol);

        $currency = app(FindOrCreateCurrencyAction::class)->execute($companyProfileData->currency);
        $country = app(FindOrCreateCountryAction::class)->execute($companyProfileData->country);
        $exchange = app(FindOrCreateExchangeAction::class)->execute($companyProfileData->exchange);
        $securityType = app(FindOrCreateSecurityTypeAction::class)->execute($stockSearchData?->type);

        $securityData = [
            'symbol' => $stockSearchData->symbol,
            'description' => $stockSearchData->description ?? $companyProfileData->name ?? $stockSearchData->symbol,
            'display_symbol' => $stockSearchData->displaySymbol ?? $stockSearchData->symbol,
            'security_type_id' => $securityType?->id,
            'currency_id' => $currency?->id,
            'country_id' => $country?->id,
            'exchange_id' => $exchange?->id,
            'logo' => $companyProfileData->logo,
            'market_capitalization' => $companyProfileData->marketCapitalization,
            'price' => $currentPriceData->currentPrice,
            'price_refresh_time' => now(),
        ];

        $security = Security::firstOrCreate(
            ['symbol' => $stockSearchData->symbol],
            $securityData
        );

        return $security;
    }
}
