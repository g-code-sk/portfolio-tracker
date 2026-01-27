<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Import;

use App\Domain\Transaction\Data\TransactionImportRowData;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\BeforeImport;

class TransactionImport implements ToCollection, WithHeadingRow, WithEvents
{
    private ?Collection $processedCollection = null;

    /**
     * @param Collection<int, Collection> $rows Collection of all rows from the sheet
     * @return Collection<int, TransactionImportRowData>
     */
    public function collection(Collection $rows): Collection
    {
        $this->processedCollection = $rows->map(function (Collection $row) {
            return TransactionImportRowData::fromCsvRow($row->toArray());
        });

        return $this->processedCollection;
    }

    /**
     * Get the processed collection
     * @return null|Collection<int, TransactionImportRowData>
     */
    public function getCollection(): ?Collection
    {
        return $this->processedCollection;
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $this->validateSheetCount($event);

                $sheet = $event->reader->getAllSheets()[0];
                $rows = $sheet->toArray();

                $this->validateFileNotEmpty($rows);
                $this->validateHeaderRow($rows);
                $this->validateDataRows($rows);
            },
        ];
    }

    private function validateSheetCount(BeforeImport $event): void
    {
        $sheetCount = $event->reader->getSheetCount();

        if ($sheetCount !== 1) {
            throw new InvalidArgumentException("File must contain exactly one sheet. Found {$sheetCount} sheets.");
        }
    }

    private function validateFileNotEmpty(array $rows): void
    {
        if (empty($rows)) {
            throw new InvalidArgumentException('File is empty.');
        }
    }

    private function validateHeaderRow(array $rows): void
    {
        $headers = $rows[0] ?? [];

        if (empty($headers) || !is_array($headers)) {
            throw new InvalidArgumentException('File must contain a header row.');
        }

        $nonEmptyHeaders = array_filter($headers, fn($header) => !empty($header));

        if (empty($nonEmptyHeaders)) {
            throw new InvalidArgumentException('Header row cannot be empty.');
        }
    }

    private function validateDataRows(array $rows): void
    {
        $dataRows = array_slice($rows, 1);

        if (empty($dataRows)) {
            throw new InvalidArgumentException('File must contain at least one data row.');
        }

        if (!$this->hasNonEmptyData($dataRows)) {
            throw new InvalidArgumentException('File must contain actual data, not just empty rows.');
        }
    }

    private function hasNonEmptyData(array $dataRows): bool
    {
        foreach ($dataRows as $row) {
            $nonEmptyValues = array_filter($row, fn($value) => !empty($value));

            if (!empty($nonEmptyValues)) {
                return true;
            }
        }

        return false;
    }
}
