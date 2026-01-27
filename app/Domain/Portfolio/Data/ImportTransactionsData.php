<?php

declare(strict_types=1);

namespace App\Domain\Portfolio\Data;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\File;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Mimes;
use Spatie\LaravelData\Data;

final class ImportTransactionsData extends Data
{
    public function __construct(
        #[Exists('portfolios', 'id')]
        public int $portfolioId,
        #[In(['trading_212', 'interactive_brokers'])]
        public string $type,
        #[File, Mimes(['csv', 'xlsx', 'xls'])]
        public UploadedFile $file,
    ) {}
}
