<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(ProductSeeder::class);
        // → add other seeders here, e.g. AdminUserSeeder::class
    }
}
