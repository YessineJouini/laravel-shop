<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the ProductSeeder to generate products
        $this->call(ProductSeeder::class);
        
        // If you have other seeders, you can call them here as well
        // For example: $this->call(AdminUserSeeder::class);
    }
}
