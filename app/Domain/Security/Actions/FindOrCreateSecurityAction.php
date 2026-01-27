<?php

declare(strict_types=1);

namespace App\Domain\Security\Actions;

use App\Domain\Finnhub\Data\FinnhubCompanyProfileData;
use App\Domain\Finnhub\Data\FinnhubCurrentPriceData;
use App\Domain\Finnhub\Data\FinnhubStockSearchItemData;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Exchange;
use App\Models\Security;
use App\Models\SecurityType;

final class FindOrCreateSecurityAction
{
    public function execute(
        FinnhubStockSearchItemData $stockSearchData,
        FinnhubCompanyProfileData $companyProfile,
        FinnhubCurrentPriceData $currentPriceData,
        ?Currency $currency = null,
        ?Country $country = null,
        ?Exchange $exchange = null,
        ?SecurityType $securityType = null,
    ): Security {

        $securityData = [
            'symbol' => $stockSearchData->symbol,
            'description' => $stockSearchData->description ?? $companyProfile->name ?? $stockSearchData->symbol,
            'display_symbol' => $stockSearchData->displaySymbol ?? $stockSearchData->symbol,
            'security_type_id' => $securityType?->id,
            'currency_id' => $currency?->id,
            'country_id' => $country?->id,
            'exchange_id' => $exchange?->id,
            'logo' => $companyProfile->logo,
            'market_capitalization' => $companyProfile->marketCapitalization,
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
