<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Marouane RIAHI',
            'email' => 'mriahi635@gmail.com',
            'password' => bcrypt('marouane@2025'),
        ]);
    }
}
