<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->where('email', 'vadkertigabor@gmail.com')->first();

        if (!$user) {
            User::factory()->create([
                'email' => 'vadkertigabor@gmail.com',
                'password' => Hash::make('password'),
            ]);
        }

        User::factory()->count(100)->create();
    }
}
