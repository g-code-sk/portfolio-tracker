<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Data;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Gte;
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
        #[Required, StringType]
        public string $stockSymbol,
        #[Required, Numeric, Gte(0.00000001)]
        public float $amount,
        #[Required, Numeric, Gte(0.00000001)]
        public float $price,
        #[Required, Date]
        public string $date,
        #[Numeric, Gte(0)]
        public float $fee = 0,
    ) {}
}
