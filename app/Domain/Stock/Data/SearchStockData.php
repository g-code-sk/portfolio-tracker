<?php

declare(strict_types=1);

namespace App\Domain\Stock\Data;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

final class SearchStockData extends Data
{
    public function __construct(
        #[Required, StringType, Min(1), Max(100)]
        public string $q,
    ) {}
}
