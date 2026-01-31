<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BrokerTypeSeeder::class,
            CurrencySeeder::class,
            TransactionTypeSeeder::class,
            UserSeeder::class,
            PortfolioSeeder::class,
        ]);
    }
}
