<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = Currency::all();

        User::all()->each(function (User $user) use ($currencies) {
            $portfolioCount = random_int(0, 3);

            if ($portfolioCount > 0) {
                Portfolio::factory()
                    ->count($portfolioCount)
                    ->for($currencies->random(), 'currency')
                    ->for($user, 'user')
                    ->create();
            }
        });
    }
}
