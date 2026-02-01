<?php

namespace Database\Seeders;

use App\Domain\TransactionType\Enums\TransactionTypeEnum;
use App\Models\TransactionType;
use Illuminate\Database\Seeder;

class TransactionTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['id' => TransactionTypeEnum::BUY->value, 'name' => 'Buy'],
            ['id' => TransactionTypeEnum::SELL->value, 'name' => 'Sell'],
            ['id' => TransactionTypeEnum::DIVIDEND->value, 'name' => 'Dividend'],
            ['id' => TransactionTypeEnum::INTEREST->value, 'name' => 'Interest'],
        ];

        collect($types)->each(function (array $type) {
            TransactionType::query()->firstOrCreate(
                ['id' => $type['id']],
                ['name' => $type['name']],
            );
        });
    }
}
