<?php

namespace Database\Seeders;

use App\Models\BrokerType;
use Illuminate\Database\Seeder;

class BrokerTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Trading 212'],
            ['name' => 'Interactive Brokers'],
        ];

        collect($types)->each(function (array $type) {
            BrokerType::query()->firstOrCreate(
                ['name' => $type['name']],
            );
        });
    }
}
