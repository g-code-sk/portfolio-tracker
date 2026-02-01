<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Data;

use App\Models\TransactionType;
use Spatie\LaravelData\Data;

final class TransactionImportRowData extends Data
{
    public function __construct(
        public ?string $action,
        public ?string $time,
        public ?string $isin,
        public ?string $ticker,
        public ?string $name,
        public ?string $notes,
        public ?string $id,
        public ?float $noOfShares,
        public ?float $priceShare,
        public ?string $currencyPriceShare,
        public ?float $exchangeRate,
        public ?float $result,
        public ?string $currencyResult,
        public ?float $total,
        public ?string $currencyTotal,
        public ?float $withholdingTax,
        public ?string $currencyWithholdingTax,
        public ?float $currencyConversionFee,
        public ?string $currencyCurrencyConversionFee,
    ) {}

    /**
     * Map snake_case CSV columns to camelCase properties
     */
    public static function fromCsvRow(array $row): self
    {
        return new self(
            action: $row['action'],
            time: $row['time'],
            isin: $row['isin'],
            ticker: $row['ticker'],
            name: $row['name'],
            notes: $row['notes'],
            id: $row['id'],
            noOfShares: isset($row['no_of_shares']) ? (float) $row['no_of_shares'] : null,
            priceShare: isset($row['price_share']) ? (float) $row['price_share'] : null,
            currencyPriceShare: $row['currency_price_share'],
            exchangeRate: isset($row['exchange_rate']) ? (float) $row['exchange_rate'] : null,
            result: isset($row['result']) ? (float) $row['result'] : null,
            currencyResult: $row['currency_result'],
            total: isset($row['total']) ? (float) $row['total'] : null,
            currencyTotal: $row['currency_total'],
            withholdingTax: isset($row['withholding_tax']) ? (float) $row['withholding_tax'] : null,
            currencyWithholdingTax: $row['currency_withholding_tax'],
            currencyConversionFee: isset($row['currency_conversion_fee']) ? (float) $row['currency_conversion_fee'] : null,
            currencyCurrencyConversionFee: $row['currency_currency_conversion_fee'],
        );
    }

    public function isValidForImport(): bool
    {
        return $this->action === TransactionType::TRADING_212_BUY_ACTION || $this->action === TransactionType::TRADING_212_SELL_ACTION && $this->noOfShares > 0 && $this->priceShare > 0;
    }
}
