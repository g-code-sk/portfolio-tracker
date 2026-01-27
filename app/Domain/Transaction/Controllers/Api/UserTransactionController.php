<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Controllers\Api;

use App\Domain\Portfolio\Actions\ImportPortfolioAction;
use App\Domain\Portfolio\Data\ImportTransactionsData;
use App\Domain\Transaction\Actions\CreateUserTransactionAction;
use App\Domain\Transaction\Data\CreateUserTransactionData;
use App\Domain\Transaction\Import\TransactionImport;
use App\Domain\Transaction\Resources\UserTransactionResource;
use App\Models\Portfolio;
use App\Models\Transaction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse as HttpJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Maatwebsite\Excel\Facades\Excel;


final class UserTransactionController
{
    use AuthorizesRequests;

    public function __construct(
        private readonly CreateUserTransactionAction $createUserTransactionAction,
    ) {}

    public function index(Request $request): JsonResource
    {
        $transactions = Transaction::query()
            ->where('user_id', $request->user()->id)
            ->with(['security', 'portfolio.currency'])
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->get();

        return UserTransactionResource::collection($transactions);
    }

    public function store(CreateUserTransactionData $data, Request $request): JsonResource
    {
        $transaction = $this->createUserTransactionAction->execute($data, $request->user()->id);
        $transaction->loadMissing(['security', 'portfolio.currency']);

        return (new UserTransactionResource($transaction))
            ->additional(['message' => 'Transaction created successfully']);
    }


    public function import(ImportTransactionsData $data): HttpJsonResponse
    {
        /** @var Portfolio */
        $portfolio = Portfolio::findOrFail($data->portfolioId);
        $this->authorize('userImportTransactions', $portfolio);

        // $result = app(ImportPortfolioAction::class)->handle($data);

        $collection = Excel::toCollection(new TransactionImport, $data->file);

        dd($collection->first()->first());

        return response()->json([
            'data' => $result,
            'message' => 'File parsed successfully',
        ]);
    }
}
