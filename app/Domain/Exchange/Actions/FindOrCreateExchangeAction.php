<?php

declare(strict_types=1);

namespace App\Domain\Exchange\Actions;

use App\Models\Exchange;

final class FindOrCreateExchangeAction
{
    public function execute(?string $exchangeCode): ?Exchange
    {
        if (! $exchangeCode) {
            return null;
        }

        return Exchange::firstOrCreate(
            ['name' => $exchangeCode]
        );
    }
}
