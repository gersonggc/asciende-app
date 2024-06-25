<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Contract;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $user2 = \App\Models\User::create([
            'name' => 'Gerson Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456')
        ]);
        $this->call([
            ContractSeeder::class,
            // ClienSeeder::class,
        ]);
        
    }
}
