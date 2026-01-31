<?php

declare(strict_types=1);

namespace App\Domain\BrokerType\Controllers;

use App\Domain\BrokerType\Resources\BrokerTypeInputResource;
use App\Models\BrokerType;
use Illuminate\Http\Resources\Json\JsonResource;

final class BrokerTypeInputController
{
    public function index(): JsonResource
    {
        $types = BrokerType::query()->orderBy('name')->get();

        return BrokerTypeInputResource::collection($types);
    }
}
