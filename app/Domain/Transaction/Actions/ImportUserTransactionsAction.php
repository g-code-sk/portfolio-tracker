<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Actions;

use App\Domain\Portfolio\Data\ImportTransactionsData;
use App\Domain\Transaction\Data\CreateUserTransactionData;
use App\Domain\Transaction\Data\TransactionImportRowData;
use App\Domain\Transaction\Import\TransactionImport;
use App\Models\Portfolio;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

final class ImportUserTransactionsAction
{
    public function __construct(
        private readonly CreateUserTransactionAction $createUserTransactionAction,
    ) {}

    /**
     * @return Collection<int, TransactionImportRowData>
     */
    public function execute(ImportTransactionsData $importTransactionsData, Portfolio $portfolio): Collection
    {
        $import = new TransactionImport();
        Excel::import($import, $importTransactionsData->file);
        $transactionRows = $import->getCollection() ?? collect();

        $transactionRows->each(function (TransactionImportRowData $transactionRowData) use ($importTransactionsData, $portfolio): void {
            if (! $transactionRowData->isValidForImport()) {
                return;
            }

            $transactionData = CreateUserTransactionData::fromTransactionImportRowData(
                importTransactionsData: $importTransactionsData,
                transactionImportRowData: $transactionRowData,
            );

            $this->createUserTransactionAction->execute(
                transactionData: $transactionData,
                userId: $portfolio->user_id,
                isin: $transactionRowData->isin,
            );
        });

        return $transactionRows;
    }
}
