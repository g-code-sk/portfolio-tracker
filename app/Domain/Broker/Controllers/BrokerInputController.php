<?php

declare(strict_types=1);

namespace App\Domain\Broker\Controllers;

use App\Domain\Broker\Resources\BrokerInputResource;
use App\Models\Broker;
use Illuminate\Http\Resources\Json\JsonResource;

final class BrokerInputController
{
    public function index(): JsonResource
    {
        $brokers = Broker::query()->orderBy('name')->get();

        return BrokerInputResource::collection($brokers);
    }
}
