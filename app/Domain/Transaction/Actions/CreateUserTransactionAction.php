<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Actions;

use App\Domain\Country\Actions\FindOrCreateCountryAction;
use App\Domain\Currency\Actions\FindOrCreateCurrencyAction;
use App\Domain\Exchange\Actions\FindOrCreateExchangeAction;
use App\Domain\Finnhub\Actions\FinnhubGetCompanyProfileAction;
use App\Domain\Finnhub\Actions\FinnhubGetCurrentPriceInfoAction;
use App\Domain\Finnhub\Actions\FinnhubSearchStockAction;
use App\Domain\Security\Actions\FindOrCreateSecurityAction;
use App\Domain\Security\Actions\FindOrCreateSecurityTypeAction;
use App\Domain\Transaction\Data\CreateUserTransactionData;
use App\Models\Transaction;

final class CreateUserTransactionAction
{
    public function __construct() {}

    public function execute(CreateUserTransactionData $requestData, int $userId): Transaction
    {
        $searchResultsData = app(FinnhubSearchStockAction::class)->executeQuery($requestData->stockSymbol);
        $currentPriceData = app(FinnhubGetCurrentPriceInfoAction::class)->executeQuery($requestData->stockSymbol);
        $companyProfileData = app(FinnhubGetCompanyProfileAction::class)->executeQuery($requestData->stockSymbol);

        // if one of the queries fail, exception is thrown and the transaction is not created

        $stockSearchData = $searchResultsData->findBySymbol($requestData->stockSymbol);

        $currency = app(FindOrCreateCurrencyAction::class)->execute($companyProfileData->currency);
        $country = app(FindOrCreateCountryAction::class)->execute($companyProfileData->country);
        $exchange = app(FindOrCreateExchangeAction::class)->execute($companyProfileData->exchange);
        $securityType = app(FindOrCreateSecurityTypeAction::class)->execute($stockSearchData?->type);

        $security = app(FindOrCreateSecurityAction::class)->execute(
            stockSearchData: $stockSearchData,
            companyProfile: $companyProfileData,
            currentPriceData: $currentPriceData,
            currency: $currency,
            country: $country,
            exchange: $exchange,
            securityType: $securityType,
        );

        $transaction = Transaction::create([
            'user_id' => $userId,
            'portfolio_id' => $requestData->portfolioId,
            'security_id' => $security->id,
            'amount' => $requestData->amount,
            'price' => $requestData->price,
            'date' => $requestData->date,
            'fee' => $requestData->fee,
        ]);

        return $transaction;
    }
}
