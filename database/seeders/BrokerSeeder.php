<?php

namespace Database\Seeders;

use App\Models\Broker;
use Illuminate\Database\Seeder;

class BrokerSeeder extends Seeder
{
    public function run(): void
    {
        $brokers = [
            ['name' => 'Trading 212'],
            ['name' => 'Interactive Brokers'],
        ];

        collect($brokers)->each(function (array $broker) {
            Broker::query()->firstOrCreate(
                ['name' => $broker['name']],
            );
        });
    }
}
