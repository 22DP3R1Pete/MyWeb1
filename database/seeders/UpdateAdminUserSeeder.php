<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find users with email admin@example.com and set the admin flag
        User::where('email', 'admin@example.com')->update(['admin' => true]);

        // Output info
        $this->command->info('Admin users updated successfully.');
    }
}
