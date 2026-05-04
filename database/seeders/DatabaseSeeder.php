<?php

namespace Database\Seeders;

use App\Enums\Role;
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
        User::updateOrCreate(
            ['email' => 'admin@mss.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Admin123'),
                'role' => Role::SuperAdmin,
                'email_verified_at' => now(),
            ]
        );
    }
}
