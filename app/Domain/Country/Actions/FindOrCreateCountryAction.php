<?php

declare(strict_types=1);

namespace App\Domain\Country\Actions;

use App\Domain\Country\Services\CountryService;
use App\Models\Country;

final class FindOrCreateCountryAction
{
    public function __construct(
        private readonly CountryService $countryService,
    ) {}

    public function execute(?string $countryCode): ?Country
    {
        if (! $countryCode) {
            return null;
        }

        return Country::firstOrCreate(
            ['code' => strtoupper($countryCode)],
            ['name' => $this->countryService->getNameByCode($countryCode)]
        );
    }
}
