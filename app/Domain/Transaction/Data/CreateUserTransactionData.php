<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Data;

use App\Domain\Portfolio\Data\ImportTransactionsData;
use App\Domain\TransactionType\Enums\TransactionTypeEnum;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\GreaterThanOrEqualTo;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

final class CreateUserTransactionData extends Data
{
    public function __construct(
        #[Required, IntegerType, Exists('portfolios', 'id')]
        public int $portfolioId,
        #[Required, IntegerType, Exists('transaction_types', 'id')]
        public int $transactionTypeId,
        #[Required, StringType]
        public string $stockSymbol,
        #[Required, Numeric, GreaterThanOrEqualTo(0.00000001)]
        public float $amount,
        #[Required, Numeric, GreaterThanOrEqualTo(0.00000001)]
        public float $price,
        #[Required, Date]
        public string $date,
        #[Numeric, GreaterThanOrEqualTo(0)]
        public float $fee = 0,
        #[Nullable]
        public ?string $externalId = null, // only for import, which uses the same data class
    ) {}

    public static function fromTransactionImportRowData(
        ImportTransactionsData $importTransactionsData,
        TransactionImportRowData $transactionImportRowData,
    ): self {
        return new self(
            portfolioId: $importTransactionsData->portfolioId,
            transactionTypeId: TransactionTypeEnum::fromTrading212Action($transactionImportRowData->action)?->value,
            stockSymbol: $transactionImportRowData->ticker,
            amount: $transactionImportRowData->noOfShares,
            price: $transactionImportRowData->priceShare,
            date: Carbon::parse($transactionImportRowData->time)->format('Y-m-d'),
            fee: $transactionImportRowData->currencyConversionFee,
            externalId: $transactionImportRowData->id,
        );
    }
}
