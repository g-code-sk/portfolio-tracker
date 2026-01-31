<?php

declare(strict_types=1);

namespace App\Domain\Portfolio\Data;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\File;
use Spatie\LaravelData\Attributes\Validation\Mimes;
use Spatie\LaravelData\Data;

final class ImportTransactionsData extends Data
{
    public function __construct(
        #[Exists('portfolios', 'id')]
        public int $portfolioId,
        #[Exists('transaction_types', 'id')]
        public int $transactionTypeId,
        #[Exists('brokers', 'id')]
        public int $brokerId,
        #[File, Mimes(['csv', 'xlsx', 'xls'])]
        public UploadedFile $file,
    ) {}
}
