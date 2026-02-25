<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // -------------------
        // Predefined Admin / Demo Users
        // -------------------
        User::updateOrCreate(
            ['email' => 'admin@mindsetboost24.com'],
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'bio' => 'The administrator of Mindset Boost 24.',
                'password' => Hash::make('password'), // Change in production
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'demo@mindsetboost24.com'],
            [
                'name' => 'Demo User',
                'username' => 'demo',
                'bio' => 'A sample demo user for testing.',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // -------------------
        // Random users via factory
        // -------------------
        User::factory()->count(50)->create();
    }
}