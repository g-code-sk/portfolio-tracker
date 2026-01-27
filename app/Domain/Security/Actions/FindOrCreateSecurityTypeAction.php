<?php

declare(strict_types=1);

namespace App\Domain\Security\Actions;

use App\Models\SecurityType;

final class FindOrCreateSecurityTypeAction
{
    public function execute(?string $name): ?SecurityType
    {
        if (! $name) {
            return null;
        }

        return SecurityType::firstOrCreate(
            ['name' => $name]
        );
    }
}
