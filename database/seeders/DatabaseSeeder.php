<?php

namespace Database\Seeders;

use App\Models\TravelOrder;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (env('APP_ENV', 'production') === 'production') {
            return;
        }

        // Seeding to easily test and use the application without having to manually insert data
        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('123456'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        for ($i = 0; $i < 10; $i++) {
            TravelOrder::factory()->forUser($admin)->create();

            $user = User::factory()->create();
            for ($j = 0; $j < 10; $j++) {
                TravelOrder::factory()->forUser($user)->create();
            }
        }
    }
}