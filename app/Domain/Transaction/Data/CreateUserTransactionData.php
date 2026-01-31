<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Data;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\GreaterThanOrEqualTo;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
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
    ) {}
}
