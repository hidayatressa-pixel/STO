<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (Schema::hasTable('users')) {
            if (Schema::hasColumn('users', 'npk') && Schema::hasColumn('users', 'jabatan') && Schema::hasColumn('users', 'level')) {
                User::firstOrCreate(
                    ['npk' => 'RESSA'],
                    [
                        'name' => 'Administrator',
                        'email' => 'admin@example.com',
                        'password' => 'admin123',
                        'level' => 'administrator',
                        'jabatan' => 'administrator',
                    ]
                );
            }

            User::firstOrCreate(
                ['email' => 'test@example.com'],
                [
                    'name' => 'Test User',
                    'npk' => 'TESTUSER',
                    'jabatan' => 'member',
                    'password' => 'password',
                ]
            );
        }
    }
}
