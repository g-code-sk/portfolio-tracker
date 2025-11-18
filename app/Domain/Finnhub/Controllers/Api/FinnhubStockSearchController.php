<?php

declare(strict_types=1);

namespace App\Domain\Finnhub\Controllers\Api;

use App\Domain\Finnhub\Actions\FinnhubSearchStockAction;
use App\Domain\Stock\Data\SearchStockData;
use App\Domain\Finnhub\Resources\FinnhubStockSearchResource;
use Illuminate\Http\Resources\Json\JsonResource;

final class FinnhubStockSearchController
{
    public function __construct(
        private readonly FinnhubSearchStockAction $searchStockAction,
    ) {}

    public function search(SearchStockData $data): JsonResource
    {
        $result = $this->searchStockAction->execute($data->q);

        return new FinnhubStockSearchResource($result);
    }
}
