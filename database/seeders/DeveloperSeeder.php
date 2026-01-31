<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create developer account if it doesn't exist
        User::firstOrCreate(
            ['email' => 'developer@stiego.com'],
            [
                'name' => 'Developer',
                'password' => Hash::make('developer123'),
                'role' => User::ROLE_DEVELOPER,
            ]
        );

        $this->command->info('Developer account created successfully!');
        $this->command->info('Email: developer@stiego.com');
        $this->command->info('Password: developer123');
    }
}
