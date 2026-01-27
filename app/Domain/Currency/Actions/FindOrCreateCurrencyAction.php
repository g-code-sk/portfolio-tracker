<?php

declare(strict_types=1);

namespace App\Domain\Currency\Actions;

use App\Domain\Currency\Services\CurrencyFormatterService;
use App\Models\Currency;

final class FindOrCreateCurrencyAction
{
    public function __construct(
        private readonly CurrencyFormatterService $currencyService,
    ) {}

    public function execute(?string $currencyCode): ?Currency
    {
        if (! $currencyCode) {
            return null;
        }

        return Currency::firstOrCreate(
            ['code' => $currencyCode],
            ['name' => $this->currencyService->getNameByCode($currencyCode)]
        );
    }
}
