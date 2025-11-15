<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            [
                'code' => 'USD',
                'name' => 'US Dollar',
            ],
            [
                'code' => 'EUR',
                'name' => 'Euro',
            ],
        ];

        collect($currencies)->each(function (array $currency) {
            Currency::query()->firstOrCreate(
                ['code' => $currency['code']],
                ['name' => $currency['name']],
            );
        });
    }
}
