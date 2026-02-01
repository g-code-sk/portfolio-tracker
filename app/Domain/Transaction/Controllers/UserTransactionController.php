<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Controllers;

use App\Domain\Portfolio\Data\ImportTransactionsData;
use App\Domain\Transaction\Actions\CreateUserTransactionAction;
use App\Domain\Transaction\Actions\ImportUserTransactionsAction;
use App\Domain\Transaction\Data\CreateUserTransactionData;
use App\Domain\Transaction\Resources\UserTransactionResource;
use App\Models\Portfolio;
use App\Models\Transaction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse as HttpJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

final class UserTransactionController
{
    use AuthorizesRequests;

    public function __construct(
        private readonly CreateUserTransactionAction $createUserTransactionAction,
        private readonly ImportUserTransactionsAction $importUserTransactionsAction,
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

    public function import(ImportTransactionsData $importTransactionsData): HttpJsonResponse
    {
        $portfolio = Portfolio::findOrFail($importTransactionsData->portfolioId);
        $this->authorize('userImportTransactions', $portfolio);

        DB::transaction(function () use ($importTransactionsData, $portfolio) {
            $transactionRows = $this->importUserTransactionsAction->execute($importTransactionsData, $portfolio);
        });

        return response()->json([
            'message' => 'File parsed successfully',
        ]);
    }
}
