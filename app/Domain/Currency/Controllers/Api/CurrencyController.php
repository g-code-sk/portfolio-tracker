<?php

declare(strict_types=1);

namespace App\Domain\Currency\Controllers\Api;

use App\Domain\Currency\Resources\CurrencySelectResource;
use App\Models\Currency;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class CurrencyController
{
    public function index(): AnonymousResourceCollection
    {
        return CurrencySelectResource::collection(
            Currency::query()->select(['id', 'name', 'code'])->orderBy('name')->get()
        );
    }
}
