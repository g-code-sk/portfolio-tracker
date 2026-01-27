<?php

declare(strict_types=1);

namespace App\Domain\Portfolio\Actions;

use App\Domain\Portfolio\Data\ImportTransactionsData;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

final class ImportPortfolioAction
{
    /**
     * Parse and extract data from the uploaded file
     *
     * @return array{headers: array<int, string>, data: array<int, array<string, mixed>>}
     */
    public function handle(ImportTransactionsData $data): array
    {
        $sheets = Excel::toArray([], $data->file);

        if (count($sheets) !== 1) {
            throw new Exception('File must contain exactly one sheet');
        }

        $sheet = $sheets[0] ?? [];

        if (empty($sheet)) {
            throw new Exception('File must contain data');
        }

        // First row is headers
        $headers = array_values($sheet[0]);

        // Remaining rows are data
        $rows = array_slice($sheet, 1);

        // Map data rows to associative arrays using headers
        $mappedData = array_map(function ($row) use ($headers) {
            $rowData = [];
            foreach ($headers as $index => $header) {
                $rowData[$header] = $row[$index] ?? null;
            }
            return $rowData;
        }, $rows);

        return [
            'headers' => $headers,
            'data' => $mappedData,
            'type' => $data->type,
            'portfolio_id' => $data->portfolioId,
            'row_count' => count($mappedData),
        ];
    }
}
