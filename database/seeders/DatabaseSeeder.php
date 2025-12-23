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
        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('123456'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        for ($i = 0; $i < 20; $i++) {
            TravelOrder::factory()->forUser($admin)->create();
        }
    }
}