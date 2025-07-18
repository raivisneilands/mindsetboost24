<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 1 admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'adminuser@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        // Create 10 regular users
        User::factory()->count(10)->create();
    }
}
