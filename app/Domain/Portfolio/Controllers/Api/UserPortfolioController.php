<?php

declare(strict_types=1);

namespace App\Domain\Portfolio\Controllers\Api;

use App\Domain\Portfolio\Resources\UserPortfolioResource;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class UserPortfolioController
{
    public function __construct() {}

    public function index(Request $request): JsonResource
    {
        /** @var Collection<int, Portfolio> */
        $portfolios = $request->user()->portfolios()->with(['currency:id,code'])->orderByDesc('created_at')->get();

        return UserPortfolioResource::collection($portfolios);
    }
}
