<?php

namespace Database\Seeders;

use App\Modules\Auth\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Field Agent
        User::updateOrCreate(
            ['email' => 'agent@example.com'],
            [
                'name' => 'Field Agent',
                'password' => Hash::make('password'),
                'role' => 'agent',
            ]
        );

        // Additional agents
        User::factory()
            ->count(2)
            ->agent()
            ->create();
    }
}