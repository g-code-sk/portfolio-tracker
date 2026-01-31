<?php

declare(strict_types=1);

namespace App\Domain\TransactionType\Controllers;

use App\Domain\TransactionType\Resources\TransactionTypeInputResource;
use App\Models\TransactionType;
use Illuminate\Http\Resources\Json\JsonResource;

final class TransactionTypeInputController
{
    public function index(): JsonResource
    {
        $types = TransactionType::query()->orderBy('name')->get();

        return TransactionTypeInputResource::collection($types);
    }
}
