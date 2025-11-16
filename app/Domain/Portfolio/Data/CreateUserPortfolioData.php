<?php

declare(strict_types=1);

namespace App\Domain\Portfolio\Data;

use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

final class CreateUserPortfolioData extends Data
{
    public function __construct(
        #[Required, StringType, Max(80)]
        public string $name,
        #[Required, IntegerType, Exists('currencies', 'id')]
        public int $currency_id,
    ) {}
}
