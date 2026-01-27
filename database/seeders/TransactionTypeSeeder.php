<?php

namespace Database\Seeders;

use App\Models\TransactionType;
use Illuminate\Database\Seeder;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Buy'],
            ['name' => 'Sell'],
            ['name' => 'Dividend'],
            ['name' => 'Interest'],
        ];

        collect($types)->each(function (array $type) {
            TransactionType::query()->firstOrCreate(
                ['name' => $type['name']],
            );
        });
    }
}
