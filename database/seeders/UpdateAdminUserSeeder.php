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
        // Find users with email admin@example.com and update with fitness data
        User::where('email', 'admin@example.com')->update([
            'admin' => true,
            'height' => 185.5,
            'weight' => 80.2,
            'birth_year' => 1985,
            'fitness_goals' => 'Strength building and muscle maintenance'
        ]);

        // Output info
        $this->command->info('Admin users updated successfully with fitness data.');
    }
}
