<?php

declare(strict_types=1);

namespace App\Domain\Portfolio\Controllers;

use App\Domain\Portfolio\Data\CreateUserPortfolioData;
use App\Domain\Portfolio\Resources\UserPortfolioResource;
use App\Models\Portfolio;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use \Illuminate\Http\JsonResponse as HttpJsonResponse;

final class UserPortfolioController
{
    use AuthorizesRequests;

    public function __construct() {}

    public function index(Request $request): JsonResource
    {
        $this->authorize('userIndex', Portfolio::class);

        /** @var Collection<int, Portfolio> */
        $portfolios = $request->user()
            ->portfolios()
            ->with(['currency:id,code'])
            ->orderByDesc('created_at')
            ->get();

        return UserPortfolioResource::collection($portfolios);
    }

    public function store(CreateUserPortfolioData $data, Request $request): JsonResource
    {
        $this->authorize('userStore', Portfolio::class);

        $portfolio = new Portfolio([
            'user_id' => $request->user()->id,
            'name' => $data->name,
            'currency_id' => $data->currency_id,
        ]);

        $portfolio->save();
        $portfolio->loadMissing(['currency:id,code']);


        return (new UserPortfolioResource($portfolio))
            ->additional(['message' => 'Portfolio created successfully']);
    }

    public function show(Portfolio $portfolio): JsonResource
    {
        $this->authorize('userShow', $portfolio);

        return new UserPortfolioResource($portfolio);
    }

    public function destroy(Portfolio $portfolio): HttpJsonResponse
    {
        $this->authorize('userDelete', $portfolio);

        $portfolio->transactions()->delete();
        $portfolio->delete();

        return response()->json([
            'message' => 'Portfolio and all associated transactions deleted successfully',
        ]);
    }
}
